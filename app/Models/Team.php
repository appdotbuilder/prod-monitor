<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $members
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sample> $samples
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team active()
 * @method static \Illuminate\Database\Eloquent\Builder|Team apparel()
 * @method static \Illuminate\Database\Eloquent\Builder|Team nonApparel()
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all members of this team.
     */
    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }

    /**
     * Get all samples assigned to this team.
     */
    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class, 'assigned_team_id');
    }

    /**
     * Scope a query to only include active teams.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include apparel teams.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApparel($query)
    {
        return $query->where('type', 'apparel');
    }

    /**
     * Scope a query to only include non-apparel teams.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonApparel($query)
    {
        return $query->where('type', 'non_apparel');
    }
}