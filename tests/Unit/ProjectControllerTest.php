<?php

namespace Tests\Unit;

use App\Models\Project;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * Test that a project can be created.
     */
    public function test_project_creation()
    {
        $project = new Project([
            'name' => 'Test Project',
            'description' => 'This is a test project',
        ]);

        $this->assertEquals('Test Project', $project->name);
        $this->assertEquals('This is a test project', $project->description);
    }

    /**
     * Test that a project requires a name.
     */
    public function test_project_requires_name()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $project = new Project();
        $project->description = 'This project has no name';
        $project->save();
    }
}
