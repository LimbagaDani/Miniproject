<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_task(): void
    {
        $response = $this->post('/tasks', [
            'task_name' => 'Finish Laravel mini project',
            'description' => 'Build the personal task manager app',
            'status' => 'Pending',
            'due_date' => '2026-10-05',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Finish Laravel mini project',
            'status' => 'Pending',
        ]);
        $this->assertDatabaseCount('tasks', 1);
    }
}
