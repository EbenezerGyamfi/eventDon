<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        Http::fake([
            'google.com/*' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '+233206687321',
            'g-recaptcha-response' => 'somsstring',
        ]);

        $this->assertAuthenticated();

        $response->assertSessionDoesntHaveErrors();

        $this->assertEquals(1, User::count());

        $this->assertEquals('client', User::first()->role);
    }
}
