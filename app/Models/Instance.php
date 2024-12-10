<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instance extends Model
{
    protected $fillable = [
        'user_id',
        'hostname',
        'minecraft_server_host',
        'minecraft_plugin_ip',
        'status',
        'is_paid',
        'is_beta',
        'version',
        'dns_verified',
        'plugin_api_token',
        'instance_api_token',
        'has_set_api_tokens',
        'deployment_status',
        'last_deployment_at',
        'last_backup_at',
        'suspended_at',
        'suspension_reason',
        'ploi_server_id',
        'ploi_site_id',
        'ploi_database_name',
        'ploi_database_user',
        'ploi_database_password',
        'ploi_ssl_enabled',
        'ploi_deployment_status',
        'ploi_deployment_error',
        'minecraft_server_host',
        'minecraft_plugin_ip'
    ];

    protected $casts = [
        'has_set_api_tokens' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'paid')
            ->first();
    }

    public function generateApiTokens(): void
    {
        $this->update([
            'plugin_api_token' => 'plt_' . bin2hex(random_bytes(32)),
            'instance_api_token' => 'ist_' . bin2hex(random_bytes(32))
        ]);
    }
}
