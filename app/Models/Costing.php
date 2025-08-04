<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Costing
 *
 * @property int $id
 * @property int $worksheet_id
 * @property float $material_cost
 * @property float $labor_cost
 * @property float $overhead_cost
 * @property float $total_cost
 * @property string $approval_status
 * @property int $created_by
 * @property int|null $production_approved_by
 * @property int|null $finance_approved_by
 * @property \Illuminate\Support\Carbon|null $production_approved_at
 * @property \Illuminate\Support\Carbon|null $finance_approved_at
 * @property string|null $approval_notes
 * @property int $revision_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Worksheet $worksheet
 * @property-read User $creator
 * @property-read User|null $productionApprover
 * @property-read User|null $financeApprover
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sample> $samples
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Costing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Costing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Costing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Costing approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Costing pending()
 * @method static \Database\Factories\CostingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Costing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'worksheet_id',
        'material_cost',
        'labor_cost',
        'overhead_cost',
        'total_cost',
        'approval_status',
        'created_by',
        'production_approved_by',
        'finance_approved_by',
        'production_approved_at',
        'finance_approved_at',
        'approval_notes',
        'revision_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'material_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'overhead_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'production_approved_at' => 'datetime',
        'finance_approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the worksheet this costing belongs to.
     */
    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
    }

    /**
     * Get the user who created this costing.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved this costing for production.
     */
    public function productionApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'production_approved_by');
    }

    /**
     * Get the user who approved this costing for finance.
     */
    public function financeApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finance_approved_by');
    }

    /**
     * Get all samples for this costing.
     */
    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }

    /**
     * Scope a query to only include approved costings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'finance_approved');
    }

    /**
     * Scope a query to only include pending costings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }
}