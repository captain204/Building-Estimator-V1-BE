<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_subscribe_a_new_user_successfully()
    {
        $data = [
            'firstname' => 'Lamine ',
            'lastname' => 'Yamal',
            'email' => 'lamineyamal@gmail.com',
            'phone' => '07048373838',
        ];

        $response = $this->postJson('/api/subscribe', $data);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'You have successfully subscribed to the newsletter!',
        ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => 'lamineyamal@gmail.com',
        ]);
    }

    /** @test */
    public function it_should_fail_if_email_already_exists()
    {
        // Create a subscriber first
        Subscriber::create([
            'firstname' => 'Lamine ',
            'lastname' => 'Yamal',
            'email' => 'lamineyamal@gmail.com',
            'phone' => '07048373838',
        ]);

        // Attempt to subscribe with the same email
        $data = [
            'firstname' => 'Lamine ',
            'lastname' => 'Yamal',
            'email' => 'lamineyamal@gmail.com',
            'phone' => '07048373838',
        ];

        // Call the POST /api/subscribe route
        $response = $this->postJson('/api/subscribe', $data);

        // Assert the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert that the correct error message is returned
        $response->assertJson([
            'message' => 'The email address is already subscribed.',
        ]);

        // Ensure the count of subscribers is still 1
        $this->assertEquals(1, Subscriber::count());
    }
}
