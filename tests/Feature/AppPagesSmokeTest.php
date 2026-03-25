<?php

namespace Tests\Feature;

use App\Models\AiMessage;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
            ->get(route('profile'))
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

    public function test_ai_chat_is_blocked_after_20_messages_in_24_hours(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 20; $i++) {
            $user->aiMessages()->create([
                'role' => 'user',
                'message' => 'Pesan '.$i,
                'mode' => 'chat',
            ]);
        }

        $response = $this->actingAs($user)->post(route('ai.chat'), [
            'message' => 'Masih bisa kirim?',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('message');

        $this->assertEquals(20, AiMessage::query()->where('user_id', $user->id)->where('mode', 'chat')->where('role', 'user')->count());
    }

    public function test_ai_chat_limit_only_counts_last_24_hours(): void
    {
        $user = User::factory()->create();

        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'user_id' => $user->id,
                'role' => 'user',
                'message' => 'Pesan lama '.$i,
                'mode' => 'chat',
                'created_at' => now()->subHours(25),
                'updated_at' => now()->subHours(25),
            ];
        }
        DB::table('ai_messages')->insert($rows);

        $response = $this->actingAs($user)->post(route('ai.chat'), [
            'message' => 'Tolong bantu rencana hari ini',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('ai_messages', [
            'user_id' => $user->id,
            'role' => 'user',
            'message' => 'Tolong bantu rencana hari ini',
            'mode' => 'chat',
        ]);
    }

    public function test_ai_chat_json_route_returns_openai_response(): void
    {
        config()->set('services.openai.key', 'test-key');
        config()->set('services.openai.model', 'gpt-4o-mini');

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Saya dibuat oleh Vega Fadan Putra untuk SoftiFY.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('ai.chat.json'), ['message' => 'kamu ini ai buatannya siapa']);

        $response->assertOk()
            ->assertJson([
                'ok' => true,
                'message' => 'kamu ini ai buatannya siapa',
                'response' => 'Saya dibuat oleh Vega Fadan Putra untuk SoftiFY.',
                'source' => 'openai',
            ]);
    }

    public function test_ai_chat_json_route_validates_message_input(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('ai.chat.json'), ['message' => '']);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['message']);
    }
}
