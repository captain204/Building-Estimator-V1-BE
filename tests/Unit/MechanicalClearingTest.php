<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MechanicalClearing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MechanicalClearingTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for authentication
        $this->admin = User::factory()->create([
            'role' => 1, // Use role 1 instead of is_admin
        ]);
    }

    /** @test */
    public function it_can_create_a_mechanical_clearing_record()
    {
        $data = [
            'area_of_land' => 500,
            'preliminary_needed' => 'Yes',
            'no_of_days' => 10,
            'category' => 'non_waterlogged',
        ];

        // Authenticate as admin
        $response = $this->actingAs($this->admin, 'sanctum')
                         ->postJson('/api/admin/mechanical-clearing', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Mechanical Clearing record created successfully',
                 ]);

        $this->assertDatabaseHas('mechanical_clearings', $data);
    }

    /** @test */
    public function it_cannot_create_duplicate_category_records()
    {
        MechanicalClearing::factory()->create(['category' => 'swampy']);

        $data = [
            'area_of_land' => 300,
            'preliminary_needed' => 'No',
            'no_of_days' => 5,
            'category' => 'swampy',
        ];

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->postJson('/api/admin/mechanical-clearing', $data);

        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                     'message' => 'A record for this category already exists. You can only update it.'
                 ]);
    }

    /** @test */
    public function it_can_retrieve_all_mechanical_clearing_records()
    {
        MechanicalClearing::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->getJson('/api/admin/mechanical-clearings');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [['id', 'area_of_land', 'preliminary_needed', 'no_of_days', 'category']],
                 ]);
    }

    /** @test */
    public function it_can_retrieve_a_specific_category_record()
    {
        MechanicalClearing::factory()->create(['category' => 'unstable_ground']);

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->getJson('/api/admin/mechanical-clearings/unstable_ground');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Mechanical Clearing record retrieved successfully',
                 ]);
    }

    /** @test */
    public function it_can_update_a_mechanical_clearing_record()
    {
        $record = MechanicalClearing::factory()->create(['category' => 'non_waterlogged']);

        $updateData = ['area_of_land' => 800];

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->putJson("/api/admin/mechanical-clearings/{$record->category}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Mechanical Clearing record updated successfully',
                 ]);

        $this->assertDatabaseHas('mechanical_clearings', array_merge($record->toArray(), $updateData));
    }

    /** @test */
    public function it_can_delete_a_mechanical_clearing_record()
    {
        $record = MechanicalClearing::factory()->create(['category' => 'swampy']);

        $response = $this->actingAs($this->admin, 'sanctum')
                         ->deleteJson("/api/admin/mechanical-clearings/{$record->category}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Mechanical Clearing record deleted successfully',
                 ]);

        $this->assertDatabaseMissing('mechanical_clearings', ['category' => 'swampy']);
    }
}
