<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Sample
 *
 * @property int $id
 * @property int $worksheet_id
 * @property int $costing_id
 * @property string $sample_code
 * @property string $status
 * @property int|null $assigned_team_id
 * @property int|null $assigned_user_id
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Worksheet $worksheet
 * @property-read Costing $costing
 * @property-read Team|null $assignedTeam
 * @property-read User|null $assignedUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SampleStep> $steps
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Sample newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample completed()
 * @method static \Database\Factories\SampleFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Sample extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'worksheet_id',
        'costing_id',
        'sample_code',
        'status',
        'assigned_team_id',
        'assigned_user_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the worksheet this sample belongs to.
     */
    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }

    /**
     * Get the costing this sample belongs to.
     */
    public function costing(): BelongsTo
    {
        return $this->belongsTo(Costing::class);
    }

    /**
     * Get the team assigned to this sample.
     */
    public function assignedTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'assigned_team_id');
    }

    /**
     * Get the user assigned to this sample.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * Get all steps for this sample.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(SampleStep::class);
    }

    /**
     * Scope a query to only include in-progress samples.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed samples.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}