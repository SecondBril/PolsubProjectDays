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
        $projects = Project::factory()->count(50)->create();
        $students = User::role('mahasiswa')->get();
        $tags = Tag::all();

        if ($students->isEmpty()) {
            $this->command->warn('Seeder Warning: Tidak ada user dengan role "mahasiswa". Isi tabel users terlebih dahulu!');
            return;
        }

        foreach ($projects as $project) {
            $leaderId = $project->team_lead_id ?: $students->random()->id;

            if (!$project->team_lead_id) {
                $project->update(['team_lead_id' => $leaderId]);
            }

            // Filter mahasiswa yang BUKAN ketua
            $potentialMembers = $students->where('id', '!=', $leaderId);

            // PERBAIKAN KRITIKAL: Tentukan batas maksimal pengambilan secara dinamis
            // Jika sisa mahasiswa cuma 2, maka rand(1, 3) akan dipaksa maksimal menjadi 2.
            $maxTake = min(3, $potentialMembers->count());

            $teamMembers = collect();
            if ($maxTake > 0) {
                $teamMembers = $potentialMembers->random(rand(1, $maxTake));
            }

            $pivotData = [];

            // Masukkan Ketua
            $pivotData[$leaderId] = [
                'role' => 'ketua',
                'contribution' => 'Mengkoordinasi tim, merancang arsitektur sistem, dan manajemen repositori.'
            ];

            // Masukkan Anggota (jika ada)
            foreach ($teamMembers as $member) {
                $pivotData[$member->id] = [
                    'role' => 'anggota',
                    'contribution' => 'Mengembangkan modul fitur, menyusun dokumentasi, dan melakukan testing UI/UX.'
                ];
            }

            $project->teamMembers()->sync($pivotData);

            // Perbaikan dinamis untuk kaitan Tags agar tidak terjadi error serupa
            if ($tags->isNotEmpty()) {
                $maxTags = min(4, $tags->count());
                $project->tags()->attach(
                    $tags->random(rand(1, $maxTags))->pluck('id')->toArray()
                );
            }
        }
    }
}
