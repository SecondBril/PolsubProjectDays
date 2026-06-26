<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ubah count factory menjadi 50 data project
        $projects = Project::factory()->count(50)->create();

        // Ambil data mahasiswa untuk anggota tim
        $students = User::role('mahasiswa')->get();
        $tags = Tag::all();

        if ($students->isEmpty()) {
            $this->command->warn('Seeder Warning: Tidak ada user dengan role "mahasiswa". Isi tabel users terlebih dahulu!');
            return;
        }

        foreach ($projects as $project) {
            // Pastikan project memiliki team_lead_id yang valid dari database mahasiswa jika factory tidak mengisinya
            $leaderId = $project->team_lead_id ?: $students->random()->id;

            if (!$project->team_lead_id) {
                $project->update(['team_lead_id' => $leaderId]);
            }

            // 2. Ambil 1-3 mahasiswa acak di luar ketua kelompok untuk menjadi anggota tambahan
            $potentialMembers = $students->where('id', '!=', $leaderId);

            // Antisipasi jika jumlah mahasiswa di DB terbatas
            $takeCount = min(rand(1, 3), $potentialMembers->count());
            $teamMembers = $takeCount > 0 ? $potentialMembers->random($takeCount) : collect();

            $pivotData = [];

            // Daftarkan Ketua kelompok ke tabel pivot
            $pivotData[$leaderId] = [
                'role' => 'ketua',
                'contribution' => 'Mengkoordinasi tim, merancang arsitektur sistem, dan manajemen repositori.'
            ];

            // Daftarkan Anggota kelompok ke tabel pivot
            foreach ($teamMembers as $member) {
                $pivotData[$member->id] = [
                    'role' => 'anggota',
                    'contribution' => 'Mengembangkan modul fitur, menyusun dokumentasi, dan melakukan testing UI/UX.'
                ];
            }

            // Sinkronisasi data tim ke relation table
            $project->teamMembers()->sync($pivotData);

            // 3. Pasangkan Tags Teknologi secara acak
            if ($tags->isNotEmpty()) {
                $project->tags()->attach(
                    $tags->random(rand(1, min(4, $tags->count())))->pluck('id')->toArray()
                );
            }
        }
    }
}
