<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a project can be created via the API.
     */
    public function test_create_project()
    {
        $response = $this->post('/api/projects', [
            'name' => 'New Project',
            'description' => 'Description of the new project',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
    }

    /**
     * Test retrieving a list of projects.
     */
    public function test_get_projects_list()
    {
        Project::factory()->count(3)->create();

        $response = $this->get('/api/projects');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /**
     * Test updating a project.
     */
    public function test_update_project()
    {
        $project = Project::factory()->create();

        $response = $this->put("/api/projects/{$project->id}", [
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', ['name' => 'Updated Project']);
    }

    /**
     * Test deleting a project.
     */
    public function test_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->delete("/api/projects/{$project->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
