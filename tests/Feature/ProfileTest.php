<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $profileData = [
            'firstname' => 'Lamine',
            'lastname' => 'Yamal',
            'country' => 'Spain',
            'builder_type' => 'Engineer',
            'phone' => '08038387393973',
            'birthdate' => '2002-01-15',
            'bio' => 'Software developer based in Spain.'
        ];

        $response = $this->postJson('/api/users/profile', $profileData);

        $response->assertStatus(201)
                 ->assertJson($profileData);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'firstname' => 'Lamine',
            'lastname' => 'Yamal',
        ]);
    }

    public function test_authenticated_user_can_view_their_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/users/profile');

        $response->assertStatus(200)
                 ->assertJson([
                     'firstname' => $profile->firstname,
                     'lastname' => $profile->lastname,
                 ]);
    }

    public function test_authenticated_user_can_update_their_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $this->actingAs($user, 'sanctum');

        $updatedData = [
            'firstname' => 'UpdatedName',
            'bio' => 'Updated bio information'
        ];

        $response = $this->putJson('/api/users/profile', $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'firstname' => 'UpdatedName',
            'bio' => 'Updated bio information'
        ]);
    }

    public function test_authenticated_user_can_delete_their_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson('/api/users/profile');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('profiles', [
            'user_id' => $user->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_profile_routes()
    {
        $profileData = [
            'firstname' => 'Lamine',
            'lastname' => 'Yamal',
            'country' => 'Spain',
        ];

        $createResponse = $this->postJson('/api/users/profile', $profileData);
        $createResponse->assertStatus(401);

        $viewResponse = $this->getJson('/api/users/profile');
        $viewResponse->assertStatus(401);

        $updateResponse = $this->putJson('/api/users/profile', $profileData);
        $updateResponse->assertStatus(401);

        $deleteResponse = $this->deleteJson('/api/users/profile');
        $deleteResponse->assertStatus(401);
    }
}
