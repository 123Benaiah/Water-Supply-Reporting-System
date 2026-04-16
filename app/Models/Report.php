<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'issue_type',
        'location',
        'latitude',
        'longitude',
        'images',
        'status',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
    ];

    public const ISSUE_TYPES = [
        'Leak',
        'No water',
        'Low pressure',
        'Contaminated water',
    ];

    public const STATUSES = [
        'Pending',
        'In Progress',
        'Resolved',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(Update::class);
    }

    public function getImagesArrayAttribute(): array
    {
        return $this->images ?? [];
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'In Progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'Resolved');
    }
}
