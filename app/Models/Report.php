<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'issue_type',
        'location',
        'latitude',
        'longitude',
        'image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Issue type options.
     */
    public const ISSUE_TYPES = [
        'Leak',
        'No water',
        'Low pressure',
        'Contaminated water',
    ];

    /**
     * Status options.
     */
    public const STATUSES = [
        'Pending',
        'In Progress',
        'Resolved',
    ];

    /**
     * Get the user who submitted this report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status updates for this report.
     */
    public function updates(): HasMany
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Scope a query to only include pending reports.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope a query to only include in progress reports.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'In Progress');
    }

    /**
     * Scope a query to only include resolved reports.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'Resolved');
    }
}
