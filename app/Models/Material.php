<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Material
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $unit
 * @property float $unit_cost
 * @property string $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MaterialRequest> $materialRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder|Material active()
 * @method static \Illuminate\Database\Eloquent\Builder|Material fabric()
 * @method static \Illuminate\Database\Eloquent\Builder|Material trim()
 * @method static \Database\Factories\MaterialFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'unit',
        'unit_cost',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'unit_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all material requests for this material.
     */
    public function materialRequests(): HasMany
    {
        return $this->hasMany(MaterialRequest::class);
    }

    /**
     * Scope a query to only include active materials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include fabric materials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFabric($query)
    {
        return $query->where('type', 'fabric');
    }

    /**
     * Scope a query to only include trim materials.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrim($query)
    {
        return $query->where('type', 'trim');
    }
}