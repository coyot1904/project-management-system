<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),  // Create a new project automatically
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['todo', 'in-progress', 'done']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
