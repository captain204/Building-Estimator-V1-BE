<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\GrassesAndShrubs;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GrassesAndShrubsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_grasses_and_shrubs()
    {
        $data = [
            'qty_area' => 10.5,
            'unit' => 'm',
            'rate' => 50.75,
            'amount' => 532.88,
            'no_of_days' => 7,
        ];

        $response = $this->postJson('/api/grasses-and-shrubs', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['qty_area' => 10.5]);
    }

    public function test_can_list_grasses_and_shrubs()
    {
        GrassesAndShrubs::factory()->count(3)->create();

        $response = $this->getJson('/api/grasses-and-shrubs');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_update_grasses_and_shrubs()
    {
        $record = GrassesAndShrubs::factory()->create();

        $response = $this->putJson("/api/grasses-and-shrubs/{$record->id}", ['no_of_days' => 15]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['no_of_days' => 15]);
    }

    public function test_can_delete_grasses_and_shrubs()
    {
        $record = GrassesAndShrubs::factory()->create();

        $response = $this->deleteJson("/api/grasses-and-shrubs/{$record->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('grasses_and_shrubs', ['id' => $record->id]);
    }
}
