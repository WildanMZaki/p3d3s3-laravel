<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'category',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    /**
     * Scope a query to filter by valid activity status.
     */
    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when(
            in_array($status, ['Planned', 'Ongoing', 'Done'], true),
            fn ($q) => $q->where('status', $status)
        );
    }
}
