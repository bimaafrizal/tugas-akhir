<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;

class AuthControllerTest extends TestCase
{
    /**
     * Test user registration with valid data.
     *
     * @return void
     */
    public function testUserRegistrationWithValidData()
    {
        // Disable notifications during the test
        Notification::fake();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'phone_num' => '089673514595',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        // Assert that the user is redirected to the email verification page after successful registration
        $response->assertStatus(302);
        $response->assertRedirect('/email/verify');

        // Assert that the user is logged in after successful registration
        $this->assertAuthenticated();

        // Assert that the user exists in the database
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'phone_num' => '089673514595',
            'role_id' => 1,
            'status' => 1,
        ]);

        // Assert that the user's password is hashed in the database
        $user = User::where('email', 'john@gmail.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));

        // Assert that the user receives an email verification notification
        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    /**
     * Test user authentication with valid credentials.
     *
     * @return void
     */
    public function testUserAuthenticationWithValidCredentials()
    {
        // Create a user for testing
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'phone_num' => '089677999000',
            'phone_num_verified_at' => Carbon::now(),
            'status' => 1, // Assuming status 1 means an active account
        ]);

        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        // Assert that the user is redirected to the intended URL after successful authentication
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test user authentication with invalid credentials.
     *
     * @return void
     */
    public function testUserAuthenticationWithInvalidCredentials()
    {
        // Create a user for testing
        $user = User::factory()->create([
            'email' => 'testinvalid@gmail.com',
            'email_verified_at' => Carbon::now(),
            'phone_num_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'phone_num' => '08967799911',
            'status' => 1,
        ]);

        $response = $this->post('/login', [
            'email' => 'testinvalid@gmail.com',
            'password' => 'wrong_password', // Incorrect password
        ]);

        // Assert that the user is redirected back with an error message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('loginError', 'Login failed');
    }

    /**
     * Test user authentication with inactive account.
     *
     * @return void
     */
    public function testUserAuthenticationWithInactiveAccount()
    {
        // Create a user for testing with an inactive account (status 0)
        $user = User::factory()->create([
            'email' => 'testinactive@gmail.com',
            'password' => Hash::make('password'),
            'phone_num' => '08967799922',
            'email_verified_at' => Carbon::now(),
            'phone_num_verified_at' => Carbon::now(),
            'status' => 0,
        ]);

        $response = $this->post('/login', [
            'email' => 'testinactive@gmail.com',
            'password' => 'password',
        ]);

        // Assert that the user is redirected back with an error message
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('loginError', 'Hubungi super admin untuk mengaktifkan akun');
    }
}
