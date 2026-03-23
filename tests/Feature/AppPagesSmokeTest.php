<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_authenticated_pages_can_be_opened(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('tasks.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('targets.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('ai.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('challenge.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('leaderboard.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('profile.index'))
            ->assertOk();
    }

    public function test_task_crud_flow_works(): void
    {
        $user = User::factory()->create();

        $store = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Task test',
            'subject' => 'Math',
            'description' => 'desc',
            'due_date' => now()->toDateString(),
        ]);

        $store->assertRedirect();
        $this->assertDatabaseHas('tasks', ['title' => 'Task test', 'user_id' => $user->id]);

        $task = Task::query()->where('user_id', $user->id)->firstOrFail();

        $this->actingAs($user)->patch(route('tasks.update', $task), [
            'title' => 'Task updated',
            'subject' => 'Science',
            'description' => 'updated',
            'due_date' => now()->addDay()->toDateString(),
        ])->assertRedirect();

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Task updated']);

        $this->actingAs($user)->patch(route('tasks.toggle', $task))->assertRedirect();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_done' => true]);

        $this->actingAs($user)->delete(route('tasks.destroy', $task))->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
