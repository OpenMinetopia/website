<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCode extends Model
{
    protected $fillable = [
        'code',
        'description',
        'type', // 'percentage', 'fixed', 'free'
        'value', // percentage or fixed amount
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'free') return $amount;
        if ($this->type === 'percentage') return ($amount * $this->value) / 100;
        if ($this->type === 'fixed') return min($amount, $this->value);
        
        return 0;
    }
} 