<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'dealer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_postcode',
        'type',
        'message',
        'contact_preference',
        'contact_time',
        'has_part_exchange',
        'part_exchange_details',
        'finance_interested',
        'finance_deposit',
        'finance_term_months',
        'status',
        'source',
        'assigned_to',
        'contacted_at',
        'qualified_at',
        'won_at',
        'lost_at',
        'lost_reason',
        'ip_address',
        'user_agent',
        'referrer',
        'notes',
    ];

    protected $casts = [
        'has_part_exchange' => 'boolean',
        'finance_interested' => 'boolean',
        'part_exchange_details' => 'array',
        'finance_deposit' => 'decimal:2',
        'contacted_at' => 'datetime',
        'qualified_at' => 'datetime',
        'won_at' => 'datetime',
        'lost_at' => 'datetime',
    ];

    // Relationships
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Query Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeForDealer($query, int $dealerId)
    {
        return $query->where('dealer_id', $dealerId);
    }

    // Helper Methods
    public function markAsContacted(): void
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);
    }

    public function markAsWon(): void
    {
        $this->update([
            'status' => 'won',
            'won_at' => now(),
        ]);
    }

    public function markAsLost(string $reason): void
    {
        $this->update([
            'status' => 'lost',
            'lost_at' => now(),
            'lost_reason' => $reason,
        ]);
    }
}
