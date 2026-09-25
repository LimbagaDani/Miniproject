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

    public function test_user_can_update_task_status(): void
    {
        $task = Task::create([
            'task_name' => 'Submit assignment',
            'description' => 'Complete the assignment before Friday',
            'status' => 'Pending',
            'due_date' => '2026-10-08',
        ]);

        $response = $this->patch("/tasks/{$task->id}/status", [
            'status' => 'Completed',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Completed',
        ]);
    }

    public function test_user_can_edit_a_task(): void
    {
        $task = Task::create([
            'task_name' => 'Prepare report',
            'description' => 'Draft the project summary',
            'status' => 'Pending',
            'due_date' => '2026-10-09',
        ]);

        $response = $this->put("/tasks/{$task->id}", [
            'task_name' => 'Prepare final report',
            'description' => 'Draft and review the final project summary',
            'status' => 'Completed',
            'due_date' => '2026-10-10',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Prepare final report',
            'description' => 'Draft and review the final project summary',
            'status' => 'Completed',
            'due_date' => '2026-10-10',
        ]);
    }

    public function test_user_can_delete_a_task(): void
    {
        $task = Task::create([
            'task_name' => 'Delete old task',
            'description' => 'Remove outdated task from list',
            'status' => 'Pending',
            'due_date' => '2026-10-07',
        ]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
