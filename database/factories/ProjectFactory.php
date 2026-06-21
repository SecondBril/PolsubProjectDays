<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Program;
use App\Models\Category;
use App\Models\CourseClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(5)),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(10),
            'program_id' => Program::inRandomOrder()->first()?->id ?? Program::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'course_class_id' => CourseClass::inRandomOrder()->first()?->id ?? CourseClass::factory(),
            'cohort' => fake()->numberBetween(2021, 2024),
            'demo_url' => fake()->optional()->url(),
            'repository_url' => fake()->optional()->url(),
            'status' => fake()->randomElement(['draft', 'pending', 'published']),
            'demo_status' => 'active',
            'is_featured' => fake()->boolean(20),
            'views_count' => fake()->numberBetween(10, 1500),
            'team_lead_id' => User::role('mahasiswa')->inRandomOrder()->first()?->id ?? User::factory(),
            'submitted_at' => now()->subDays(fake()->numberBetween(1, 30)),
            'published_at' => now()->subDays(fake()->numberBetween(0, 10)),
        ];
    }
}
