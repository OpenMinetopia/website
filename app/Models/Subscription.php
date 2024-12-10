<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'instance_id',
        'starts_at',
        'ends_at',
        'duration',
        'amount',
        'payment_method',
        'status',
        'payment_id',
        'renewal_7_days_sent',
        'renewal_2_days_sent',
        'renewal_today_sent',
        'renewed_at',
        'renewal_status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }
}
