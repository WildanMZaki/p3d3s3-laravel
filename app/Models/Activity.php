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
        'registered_count',
        'status',
        'poster_path',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
            'capacity' => 'integer',
            'registered_count' => 'integer',
        ];
    }

    // Scopes
    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeFilterCategory($query, ?int $categoryId)
    {
        return $query->when($categoryId, fn ($q) => $q->where('category_id', $categoryId));
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        $allowed = ['draft', 'published', 'completed'];

        return $query->when(in_array($status, $allowed, true), fn ($q) => $q->where('status', $status));
    }

    public function scopeSortDate($query, ?string $sort)
    {
        $direction = ($sort === 'oldest') ? 'asc' : 'desc';

        return $query->orderBy('start_at', $direction);
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
