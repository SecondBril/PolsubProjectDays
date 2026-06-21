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
        $projects = Project::factory()->count(30)->create();
        $students = User::role('mahasiswa')->get();
        $tags = Tag::all();

        foreach ($projects as $project) {
            // 1. Assign Anggota Tim (1-3 mahasiswa acak + ketua tim)
            $teamMembers = $students->random(rand(1, 3));
            if (!$teamMembers->contains($project->team_lead_id)) {
                $teamMembers->push($project->teamLead);
            }

            $pivotData = [];
            foreach ($teamMembers as $member) {
                $pivotData[$member->id] = [
                    'role' => $member->id === $project->team_lead_id ? 'ketua' : 'anggota'
                ];
            }
            $project->teamMembers()->sync($pivotData);

            // 2. Assign Tags Teknologi
            if ($tags->isNotEmpty()) {
                $project->tags()->attach($tags->random(rand(1, 4))->pluck('id')->toArray());
            }
        }
    }
}
