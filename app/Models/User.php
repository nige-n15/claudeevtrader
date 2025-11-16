<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role Constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_DEALER = 'dealer';
    public const ROLE_CUSTOMER = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'dealer_id',
        'current_dealer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships

    /**
     * The dealer this user belongs to (for dealer users)
     */
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * The currently active dealer (for admin switching)
     */
    public function currentDealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class, 'current_dealer_id');
    }

    /**
     * Dealers this customer is associated with (for customer users)
     */
    public function dealers(): BelongsToMany
    {
        return $this->belongsToMany(Dealer::class, 'customer_dealer')
            ->withTimestamps();
    }

    /**
     * Leads assigned to this user
     */
    public function assignedLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    // Role Helper Methods

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDealer(): bool
    {
        return $this->role === self::ROLE_DEALER;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    /**
     * Get the active dealer for this user
     * - Admin: uses current_dealer_id for switching
     * - Dealer: uses dealer_id
     * - Customer: returns null
     */
    public function getActiveDealerAttribute(): ?Dealer
    {
        if ($this->isAdmin() && $this->current_dealer_id) {
            return $this->currentDealer;
        }

        if ($this->isDealer() && $this->dealer_id) {
            return $this->dealer;
        }

        return null;
    }

    /**
     * Switch to a different dealer (admin only)
     */
    public function switchToDealer(?int $dealerId): void
    {
        if ($this->isAdmin()) {
            $this->current_dealer_id = $dealerId;
            $this->save();
        }
    }

    /**
     * Check if user can access dealer dashboard
     */
    public function canAccessDealerDashboard(): bool
    {
        return $this->isAdmin() || $this->isDealer();
    }
}
