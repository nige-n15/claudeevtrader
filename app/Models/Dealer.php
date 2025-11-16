<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'trading_name',
        'company_number',
        'vat_number',
        'email',
        'phone',
        'website',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'country',
        'description',
        'logo_url',
        'contact_preferences',
        'opening_hours',
        'display_phone',
        'display_email',
        'allow_reservations',
        'status',
    ];

    protected $casts = [
        'contact_preferences' => 'array',
        'opening_hours' => 'array',
        'display_phone' => 'boolean',
        'display_email' => 'boolean',
        'allow_reservations' => 'boolean',
    ];

    // Relationships
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function importJobs(): HasMany
    {
        return $this->hasMany(ImportJob::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_dealer')
            ->where('role', User::ROLE_CUSTOMER)
            ->withTimestamps();
    }

    // Buyer Journey Configuration Methods
    public function getBuyerJourneyConfig(): array
    {
        return $this->contact_preferences ?? $this->getDefaultBuyerJourneyConfig();
    }

    public function getDefaultBuyerJourneyConfig(): array
    {
        return [
            'enabled_methods' => ['phone', 'email'],
            'primary_cta' => 'phone',
            'show_phone' => true,
            'show_email' => true,
            'show_test_drive' => false,
            'show_reservation' => false,
            'reservation_settings' => [
                'deposit_amount' => 99,
                'expiry_hours' => 48,
                'terms' => null,
            ],
            'response_time_commitment' => 'within 2 hours',
            'whatsapp_number' => null,
        ];
    }

    public function updateBuyerJourneyConfig(array $config): void
    {
        $this->contact_preferences = array_merge($this->getBuyerJourneyConfig(), $config);
        $this->save();
    }

    // Query Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithActiveSubscription($query)
    {
        return $query->whereHas('subscription', function ($q) {
            $q->where('status', 'active');
        });
    }

    // Helper Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->status === 'active';
    }

    public function canAddVehicle(): bool
    {
        if (! $this->hasActiveSubscription()) {
            return false;
        }

        $currentVehicleCount = $this->vehicles()->count();

        return $currentVehicleCount < $this->subscription->vehicle_limit;
    }
}
