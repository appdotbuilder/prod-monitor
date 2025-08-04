<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SampleStep
 *
 * @property int $id
 * @property int $sample_id
 * @property string $step_type
 * @property string $status
 * @property int|null $assigned_to
 * @property \Illuminate\Support\Carbon|null $assigned_at
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string|null $notes
 * @property array|null $step_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Sample $sample
 * @property-read User|null $assignedUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MaterialRequest> $materialRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|SampleStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleStep query()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleStep assigned()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleStep completed()
 * @method static \Database\Factories\SampleStepFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class SampleStep extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sample_id',
        'step_type',
        'status',
        'assigned_to',
        'assigned_at',
        'started_at',
        'completed_at',
        'notes',
        'step_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'step_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the sample this step belongs to.
     */
    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    /**
     * Get the user assigned to this step.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all material requests for this step.
     */
    public function materialRequests(): HasMany
    {
        return $this->hasMany(MaterialRequest::class);
    }

    /**
     * Scope a query to only include assigned steps.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope a query to only include completed steps.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}