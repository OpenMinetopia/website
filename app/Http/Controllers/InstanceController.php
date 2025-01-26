<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Services\DnsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Notifications\InstanceCreated;
use App\Services\PloiService;
use App\Notifications\InstanceActivated;
use Illuminate\Support\Facades\DB;
use App\Models\DiscountCode;

class InstanceController extends Controller
{
    public function __construct(private DnsService $dnsService)
    {
    }

    public function index()
    {
        $instances = auth()->user()->instances()->latest()->get();
        return view('instances.index', compact('instances'));
    }

    public function create()
    {
        return view('instances.create', [
            'durations' => array_keys(config('instances.pricing')),
            'payment_methods' => array_keys(config('instances.payment_methods'))
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hostname' => ['required', 'string', 'max:255', Rule::unique('instances')],
            'duration' => ['required', Rule::in(array_keys(config('instances.pricing')))],
            'payment_method' => ['required', Rule::in(array_keys(config('instances.payment_methods')))],
            'minecraft_server_host' => ['required', 'string', 'max:255'],
            'minecraft_plugin_ip' => ['required', 'string', 'max:255'],
            'discount_code' => ['nullable', 'string', 'exists:discount_codes,code'],
        ]);

        $instance = DB::transaction(function() use ($validated, $request) {
            // Find discount code if provided
            $discountCode = null;
            $discountAmount = 0;
            
            if ($request->filled('discount_code')) {
                $discountCode = DiscountCode::where('code', $request->discount_code)
                    ->where('is_active', true)
                    ->first();

                if ($discountCode && $discountCode->isValid()) {
                    $amount = config('instances.pricing')[$validated['duration']];
                    $discountAmount = $discountCode->calculateDiscount($amount);
                }
            }

            // Create instance
            $instance = auth()->user()->instances()->create([
                'hostname' => $validated['hostname'],
                'minecraft_server_host' => $validated['minecraft_server_host'],
                'minecraft_plugin_ip' => $validated['minecraft_plugin_ip'],
                'status' => 'pending',
                'deployment_status' => 'uncompleted',
                'discount_code_id' => $discountCode?->id,
                'discount_amount' => $discountAmount
            ]);

            // Generate API tokens
            $instance->generateApiTokens();

            // Create subscription with discounted amount
            $amount = config('instances.pricing')[$validated['duration']];
            $finalAmount = max(0, $amount - ($discountAmount ?? 0));

            $instance->subscriptions()->create([
                'starts_at' => now(),
                'ends_at' => now()->addDays(7),
                'duration' => $validated['duration'],
                'amount' => $finalAmount,
                'payment_method' => $validated['payment_method'],
                'status' => $finalAmount === 0 ? 'paid' : 'pending',
                'is_trial' => true
            ]);

            // Increment usage count for discount code
            if ($discountCode) {
                $discountCode->increment('used_count');
            }

            $instance->refresh();
            $instance->user->notify((new InstanceCreated($instance))->onQueue('notifications'));

            return $instance;
        });

        return redirect()->route('instances.show', $instance)
            ->with('success', 'Je proefperiode is aangevraagd! Stel de DNS en plugin configuratie in om je portal te activeren.');
    }

    public function show(Instance $instance)
    {
        if (! Gate::allows('view', $instance)) {
            abort(403);
        }

        // Verify DNS and update status
        $dnsVerified = $this->dnsService->verifyHostname($instance->hostname);
        if ($dnsVerified !== $instance->dns_verified) {
            $instance->update(['dns_verified' => $dnsVerified]);
        }

        return view('instances.show', [
            'instance' => $instance,
            'dnsVerified' => $dnsVerified,
            'serverIp' => config('instances.server_ip')
        ]);
    }

    public function edit(Instance $instance)
    {
        if (! Gate::allows('update', $instance)) {
            abort(403);
        }

        return view('instances.edit', compact('instance'));
    }

    public function update(Request $request, Instance $instance)
    {
        if (! Gate::allows('update', $instance)) {
            abort(403);
        }

        // Add update logic here
    }

    public function destroy(Instance $instance)
    {
        if (! Gate::allows('delete', $instance)) {
            abort(403);
        }

        $instance->delete();
        return redirect()->route('instances.index')
            ->with('success', 'Instance deleted successfully.');
    }

    public function verifyDns(Instance $instance)
    {
        if (! Gate::allows('update', $instance)) {
            abort(403);
        }

        $dnsVerified = $this->dnsService->verifyHostname($instance->hostname);

        // Update the dns_verified status based on the actual DNS check
        $instance->update(['dns_verified' => $dnsVerified]);

        if ($dnsVerified) {
            return back()->with('success', 'DNS configuration verified successfully!');
        }

        return back()->with('error', 'DNS verification failed. Please check your configuration and try again.');
    }

    public function toggleBeta(Instance $instance)
    {
        if (! Gate::allows('update', $instance)) {
            abort(403);
        }

        $instance->update(['is_beta' => !$instance->is_beta]);

        return back()->with('success', $instance->is_beta ? 'Beta features enabled.' : 'Beta features disabled.');
    }

    public function markApiTokensAsSet(Instance $instance)
    {
        if (! Gate::allows('update', $instance)) {
            abort(403);
        }

        $instance->update(['has_set_api_tokens' => true]);
        return back()->with('success', 'API tokens marked as configured.');
    }

    public function renew(Request $request, Instance $instance)
    {
        if (!Gate::allows('update', $instance)) {
            abort(403);
        }

        $validated = $request->validate([
            'duration' => ['required', Rule::in(array_keys(config('instances.pricing')))],
        ]);

        $amount = config('instances.pricing')[$validated['duration']];
        
        // Create new subscription
        $instance->subscriptions()->create([
            'starts_at' => now(),
            'ends_at' => now()->add($validated['duration']),
            'duration' => $validated['duration'],
            'amount' => $amount,
            'status' => 'pending',
            'renewal_status' => 'pending'
        ]);

        return redirect()->route('instances.show', $instance)
            ->with('success', 'Renewal request submitted. Please complete the payment to activate your subscription.');
    }

    public function updateMinecraftConfig(Request $request, Instance $instance)
    {
        $validated = $request->validate([
            'minecraft_server_host' => ['required', 'string', 'max:255'],
            'minecraft_plugin_ip' => ['required', 'string', 'max:255'],
        ]);

        $instance->update($validated);

        return back()->with('success', 'Minecraft configuratie bijgewerkt.');
    }

    public function updateHostname(Request $request, Instance $instance)
    {
        if ($instance->status !== 'pending') {
            return back()->with('hostname_error', true);
        }

        $validated = $request->validate([
            'hostname' => ['required', 'string', 'max:255', Rule::unique('instances')->ignore($instance)],
        ]);

        $instance->update([
            'hostname' => $validated['hostname']
        ]);

        return back()->with('success', 'Hostname bijgewerkt.');
    }

    public function convertTrial(Instance $instance)
    {
        if (!Gate::allows('update', $instance)) {
            abort(403);
        }

        $subscription = $instance->subscriptions->first();
        
        if (!$subscription->is_trial || $subscription->trial_converted) {
            return back()->with('error', 'Deze actie is niet mogelijk voor dit abonnement.');
        }

        $subscription->update([
            'trial_converted' => true,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Bedankt voor je aanvraag! Zodra je betaling binnen is (dit kan tot 24 uur duren), wordt je abonnement geactiveerd.');
    }
}
