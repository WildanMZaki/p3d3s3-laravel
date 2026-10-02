<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use DomainException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        $nextStatus = $data['status'] ?? $activity->status;
        $this->ensureValidTransition($activity->status, $nextStatus);

        $activity->update($data);

        return $activity->refresh();
    }

    public function delete(Activity $activity): bool
    {
        return (bool) $activity->delete();
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw new DomainException(
                "Transisi status dari {$current} ke {$next} tidak diizinkan."
            );
        }
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

    public function registerParticipant(Activity $activity, array $data): Registration
    {
        // Validasi status kegiatan
        if ($activity->status !== 'published') {
            throw new DomainException('Pendaftaran hanya dapat dilakukan untuk kegiatan yang berstatus published.');
        }

        // Validasi jadwal kegiatan
        if ($activity->start_at && Carbon::parse($activity->start_at)->isPast()) {
            throw new DomainException('Pendaftaran ditolak karena kegiatan sudah dimulai atau telah lewat.');
        }

        // Validasi kuota peserta
        if ($activity->registered_count >= $activity->capacity) {
            throw new DomainException('Pendaftaran ditolak karena kuota peserta telah penuh.');
        }

        // Mencegah pendaftaran duplikat
        if ($activity->registrations()->where('email', $data['email'])->exists()) {
            throw new DomainException('Email ini sudah terdaftar pada kegiatan tersebut.');
        }

        // Simpan pendaftaran dan update kapasitas secara atomik
        return DB::transaction(function () use ($activity, $data) {
            $registration = $activity->registrations()->create([
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => now(),
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}
