<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dealer_id',
        'vin',
        'registration',
        'make',
        'model',
        'variant',
        'year',
        'mileage',
        'mileage_unit',
        'price',
        'original_price',
        'price_negotiable',
        'price_notes',
        'body_type',
        'fuel_type',
        'transmission',
        'engine_size',
        'engine_power',
        'doors',
        'seats',
        'drivetrain',
        'exterior_color',
        'interior_color',
        'condition',
        'previous_owners',
        'service_history',
        'hpi_clear',
        'mot_expiry',
        'tax_expiry',
        'road_tax_annual',
        'features',
        'description',
        'video_url',
        'status',
        'reserved_at',
        'sold_at',
        'featured',
        'views_count',
        'leads_count',
        'import_job_id',
        'external_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'road_tax_annual' => 'decimal:2',
        'price_negotiable' => 'boolean',
        'hpi_clear' => 'boolean',
        'featured' => 'boolean',
        'features' => 'array',
        'mot_expiry' => 'date',
        'tax_expiry' => 'date',
        'reserved_at' => 'datetime',
        'sold_at' => 'datetime',
    ];

    // Relationships
    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class)->orderBy('order');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function importJob(): BelongsTo
    {
        return $this->belongsTo(ImportJob::class);
    }

    // Accessors
    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->first();
    }

    public function getFormattedPriceAttribute(): string
    {
        return '£'.number_format($this->price, 0);
    }

    public function getFullTitleAttribute(): string
    {
        $parts = array_filter([
            $this->year,
            $this->make,
            $this->model,
            $this->variant,
        ]);

        return implode(' ', $parts);
    }

    // Query Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeForDealer($query, int $dealerId)
    {
        return $query->where('dealer_id', $dealerId);
    }

    // Helper Methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }

    public function isSold(): bool
    {
        return $this->status === 'sold';
    }

    public function reserve(): void
    {
        $this->update([
            'status' => 'reserved',
            'reserved_at' => now(),
        ]);
    }

    public function markAsSold(): void
    {
        $this->update([
            'status' => 'sold',
            'sold_at' => now(),
        ]);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementLeads(): void
    {
        $this->increment('leads_count');
    }
}
