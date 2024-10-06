<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        // Create a project first
        $project = Project::factory()->create();

        // Define the task data
        $taskData = [
            'project_id' => $project->id,
            'name' => 'Sample Task',
            'description' => 'This is a test task',
            'status' => 'todo',
        ];

        // Send a POST request to create the task
        $response = $this->post('/api/tasks', $taskData);

        // Assert that the task was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        // Create a task using the factory
        $task = Task::factory()->create([
            'name' => 'Initial Task',
            'status' => 'todo',
        ]);

        // Define the updated task data
        $updatedData = [
            'name' => 'Updated Task',
            'status' => 'in-progress',
        ];

        // Send a PUT request to update the task
        $response = $this->put("/api/tasks/{$task->id}", $updatedData);

        // Assert that the update was successful
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        // Create a task using the factory
        $task = Task::factory()->create();

        // Send a DELETE request to delete the task
        $response = $this->delete("/api/tasks/{$task->id}");

        // Assert that the deletion was successful
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_can_list_all_tasks_for_a_project()
    {
        // Create a project
        $project = Project::factory()->create();

        // Create 5 tasks associated with this project
        Task::factory()->count(5)->create(['project_id' => $project->id]);

        // Send a GET request to retrieve tasks for the project
        $response = $this->get("/api/projects/{$project->id}/tasks");

        // Assert that the request was successful and 5 tasks are returned
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }
}
