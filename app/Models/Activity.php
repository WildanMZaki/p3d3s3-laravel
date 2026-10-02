<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'start_at',
        'end_at',
        'location',
        'capacity',
        'status',
        'poster_path',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
            'capacity' => 'integer',
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

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
