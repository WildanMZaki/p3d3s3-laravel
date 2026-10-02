<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const TRANSITIONS = [
        'draft' => ['draft', 'published'],
        'published' => ['published', 'completed'],
        'completed' => ['completed'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $activity->update($data);

        return $activity->refresh();
    }

    public function delete(Activity $activity): bool
    {
        return (bool) $activity->delete();
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan berstatus draft yang dapat dipublikasikan.',
            ]);
        }

        // Validasi kelengkapan data
        if (
            ! $activity->category_id || ! $activity->code || ! $activity->title ||
            ! $activity->location || ! $activity->start_at || ! $activity->end_at || ! $activity->capacity
        ) {
            throw ValidationException::withMessages([
                'status' => 'Kegiatan tidak dapat dipublikasikan karena informasi wajib belum lengkap.',
            ]);
        }

        $activity->update(['status' => 'published']);

        return $activity;
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan berstatus published yang dapat diselesaikan.',
            ]);
        }

        $activity->update(['status' => 'completed']);

        return $activity;
    }
}
