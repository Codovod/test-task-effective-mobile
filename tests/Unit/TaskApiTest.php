<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Создаём пользователя для аутентификации
        $this->user = User::factory()->create();
    }

    /**
     * Тест: Получение списка задач (GET /api/tasks)
     */
    public function test_can_get_tasks_list()
    {
        Task::factory()->count(3)->create();


        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([[
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at'
            ]]);
    }


    /**
     * Тест: Создание задачи (POST /api/tasks)
     */
    public function test_can_create_task()
    {
        $data = [
            'title' => 'Новая задача',
            'status' => 'in_progress',
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'status',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => $data['title'],
            'status' => $data['status'],
        ]);
    }

    /**
     * Тест: Получение конкретной задачи (GET /api/tasks/{id})
     */
    public function test_can_get_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
            ]);
    }

    /**
     * Тест: Обновление задачи (PUT/PATCH /api/tasks/{id})
     */
    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        $updatedData = [
            'title' => 'Обновлённая задача',
            'status' => 'completed', // можно менять статус
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", $updatedData);


        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $updatedData['title'],
            'description' => $task->description,
            'status' => $updatedData['status'],
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ]);
    }

    /**
     * Тест: Удаление задачи (DELETE /api/tasks/{id})
     */
    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Тест: Доступ без аутентификации (401 Unauthorized)
     */
    public function test_unauthenticated_user_cannot_access_tasks()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }
}
