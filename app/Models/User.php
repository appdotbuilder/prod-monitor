<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property int|null $team_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Worksheet> $createdWorksheets
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Worksheet> $approvedWorksheets
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Costing> $createdCostings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sample> $assignedSamples
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SampleStep> $assignedSteps
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MaterialRequest> $materialRequests
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User managers()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
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
        'name',
        'email',
        'password',
        'role',
        'team_id',
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

    /**
     * Get the team this user belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get worksheets created by this user.
     */
    public function createdWorksheets(): HasMany
    {
        return $this->hasMany(Worksheet::class, 'created_by');
    }

    /**
     * Get worksheets approved by this user.
     */
    public function approvedWorksheets(): HasMany
    {
        return $this->hasMany(Worksheet::class, 'approved_by');
    }

    /**
     * Get costings created by this user.
     */
    public function createdCostings(): HasMany
    {
        return $this->hasMany(Costing::class, 'created_by');
    }

    /**
     * Get samples assigned to this user.
     */
    public function assignedSamples(): HasMany
    {
        return $this->hasMany(Sample::class, 'assigned_user_id');
    }

    /**
     * Get sample steps assigned to this user.
     */
    public function assignedSteps(): HasMany
    {
        return $this->hasMany(SampleStep::class, 'assigned_to');
    }

    /**
     * Get material requests made by this user.
     */
    public function materialRequests(): HasMany
    {
        return $this->hasMany(MaterialRequest::class, 'requested_by');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include managers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManagers($query)
    {
        return $query->whereIn('role', ['production_manager', 'finance_manager']);
    }
}