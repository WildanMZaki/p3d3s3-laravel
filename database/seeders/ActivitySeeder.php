<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workshopId = Category::where('slug', 'workshop')->value('id') ?? 1;
        $seminarId = Category::where('slug', 'seminar')->value('id') ?? 2;
        $kompetisiId = Category::where('slug', 'kompetisi')->value('id') ?? 3;

        Activity::query()->forceDelete();

        Activity::query()->insert([
            [
                'category_id' => $workshopId,
                'code' => 'ACT-001',
                'title' => 'Workshop Git & GitHub Advanced',
                'description' => 'Latihan kolaborasi repository, branching strategy, dan resolving conflicts.',
                'start_at' => '2026-10-05',
                'end_at' => '2026-10-06',
                'location' => 'Lab Komputer 1',
                'capacity' => 40,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $seminarId,
                'code' => 'ACT-002',
                'title' => 'Seminar Web Quality & Architecture',
                'description' => 'Pengenalan maintainability, static analysis, dan testing pada Laravel.',
                'start_at' => '2026-10-12',
                'end_at' => '2026-10-12',
                'location' => 'Auditorium Gedung D',
                'capacity' => 150,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $workshopId,
                'code' => 'ACT-003',
                'title' => 'Sesi Praktikum Modul 3 Special Challenge',
                'description' => 'Pengerjaan Advanced CRUD, Data Integrity, dan Relasional Eloquent.',
                'start_at' => '2026-10-15',
                'end_at' => '2026-10-16',
                'location' => 'Lab Rekayasa Perangkat Lunak',
                'capacity' => 35,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $seminarId,
                'code' => 'ACT-004',
                'title' => 'Review Desain Arsitektur Perangkat Lunak',
                'description' => 'Diskusi pembagian layer controller, service, domain invariant, dan database constraint.',
                'start_at' => '2026-10-20',
                'end_at' => '2026-10-20',
                'location' => 'Ruang Teori 2',
                'capacity' => 60,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $kompetisiId,
                'code' => 'ACT-005',
                'title' => 'Hackathon Web Development 2026',
                'description' => 'Kompetisi pembuatan aplikasi web terintegrasi 24 jam.',
                'start_at' => '2026-11-01',
                'end_at' => '2026-11-02',
                'location' => 'Hall Utama Kampus',
                'capacity' => 100,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
