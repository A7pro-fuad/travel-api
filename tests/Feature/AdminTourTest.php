<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTourTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_cannot_access_adding_tour(): void
    {
        $travel = Travel::factory()->create();
        $response = $this->postJson('api/v1/admin/travels/'.$travel->id.'/tours');
        $response->assertStatus(401);
    }

    public function test_non_admin_user_cannot_access_adding_tour(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $travel = Travel::factory()->create();
        $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours');
        $response->assertStatus(403);
    }
}
