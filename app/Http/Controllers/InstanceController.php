<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Services\DnsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

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
            'payment_method' => ['required', Rule::in(array_keys(config('instances.payment_methods')))]
        ]);

        $instance = auth()->user()->instances()->create([
            'hostname' => $validated['hostname'],
            'status' => 'pending',
            'deployment_status' => 'uncompleted',
        ]);

        // Generate API tokens
        $instance->generateApiTokens();

        // Create subscription
        $amount = config('instances.pricing')[$validated['duration']];
        $starts_at = now();
        $ends_at = match($validated['duration']) {
            '1_month' => $starts_at->addMonth(),
            '3_months' => $starts_at->addMonths(3),
            '6_months' => $starts_at->addMonths(6),
            '12_months' => $starts_at->addYear(),
        };

        $instance->subscriptions()->create([
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'duration' => $validated['duration'],
            'amount' => $amount,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending'
        ]);

        return redirect()->route('instances.show', $instance)
            ->with('success', 'Instance created successfully. Please complete the payment and DNS setup.');
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
}
