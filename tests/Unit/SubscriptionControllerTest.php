<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    
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

    
    public function it_should_fail_if_email_already_exists()
    {
        Subscriber::create([
            'firstname' => 'Lamine ',
            'lastname' => 'Yamal',
            'email' => 'lamineyamal@gmail.com',
            'phone' => '07048373838',
        ]);

        $data = [
            'firstname' => 'Lamine ',
            'lastname' => 'Yamal',
            'email' => 'lamineyamal@gmail.com',
            'phone' => '07048373838',
        ];

        $response = $this->postJson('/api/subscribe', $data);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The email address is already subscribed.',
        ]);

        $this->assertEquals(1, Subscriber::count());
    }
}
