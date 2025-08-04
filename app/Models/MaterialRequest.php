<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MaterialRequest
 *
 * @property int $id
 * @property int $sample_step_id
 * @property int $material_id
 * @property float $quantity
 * @property string $source
 * @property string $status
 * @property int $requested_by
 * @property \Illuminate\Support\Carbon $requested_at
 * @property \Illuminate\Support\Carbon|null $received_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read SampleStep $sampleStep
 * @property-read Material $material
 * @property-read User $requester
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialRequest received()
 * @method static \Illuminate\Database\Eloquent\Builder|MaterialRequest pending()
 * @method static \Database\Factories\MaterialRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class MaterialRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sample_step_id',
        'material_id',
        'quantity',
        'source',
        'status',
        'requested_by',
        'requested_at',
        'received_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'decimal:2',
        'requested_at' => 'datetime',
        'received_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the sample step this request belongs to.
     */
    public function sampleStep(): BelongsTo
    {
        return $this->belongsTo(SampleStep::class);
    }

    /**
     * Get the material for this request.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the user who made this request.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Scope a query to only include received requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReceived($query)
    {
        return $query->where('status', 'received');
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['requested', 'sourcing', 'ordered']);
    }
}