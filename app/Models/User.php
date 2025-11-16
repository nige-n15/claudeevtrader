<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'dealer_id',
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function assignedLeads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    // Role Helper Methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDealerOwner(): bool
    {
        return $this->role === 'dealer_owner';
    }

    public function isDealerManager(): bool
    {
        return $this->role === 'dealer_manager';
    }

    public function isDealerStaff(): bool
    {
        return $this->role === 'dealer_staff';
    }

    public function canManageDealer(): bool
    {
        return in_array($this->role, ['admin', 'dealer_owner', 'dealer_manager']);
    }
}
