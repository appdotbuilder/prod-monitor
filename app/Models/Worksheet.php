<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Worksheet
 *
 * @property int $id
 * @property string $worksheet_number
 * @property string $product_name
 * @property string|null $description
 * @property string $status
 * @property string|null $production_type
 * @property int $created_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string|null $approval_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $creator
 * @property-read User|null $approver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Costing> $costings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sample> $samples
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Worksheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worksheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Worksheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Worksheet approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Worksheet pending()
 * @method static \Database\Factories\WorksheetFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Worksheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'worksheet_number',
        'product_name',
        'description',
        'status',
        'production_type',
        'created_by',
        'approved_by',
        'approved_at',
        'approval_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this worksheet.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved this worksheet.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all costings for this worksheet.
     */
    public function costings(): HasMany
    {
        return $this->hasMany(Costing::class);
    }

    /**
     * Get all samples for this worksheet.
     */
    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }

    /**
     * Scope a query to only include approved worksheets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending worksheets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}