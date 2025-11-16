<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'plan',
        'vehicle_limit',
        'monthly_price',
        'status',
        'started_at',
        'current_period_start',
        'current_period_end',
        'cancelled_at',
        'trial_ends_at',
        'stripe_subscription_id',
        'stripe_customer_id',
        'payment_method',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'started_at' => 'datetime',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'cancelled_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    // Relationships
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    // Query Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Helper Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function daysUntilRenewal(): int
    {
        return now()->diffInDays($this->current_period_end, false);
    }
}
