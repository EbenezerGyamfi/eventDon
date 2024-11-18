<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_clients_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'role' => 'client',
            'phone_number_verified' => '1',
        ]);

        Http::fake([
            'google.com/*' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'g-recaptcha-response' => 'sometoken',

        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('events.index'));
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
