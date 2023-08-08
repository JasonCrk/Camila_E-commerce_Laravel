<?php

namespace Tests\Feature\auth;

use App\Mail\SuccessfulUserRegistrationEmail;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private string $url;
    private string $password;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->url = route('auth.register');
        $this->password = fake()->password(8);
    }

    public function test_returns_a_successful_response(): void
    {
        $response = $this->postJson($this->url, [
            'username' => fake()->unique()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'Successful registration'
        ]);
    }

    public function test_user_has_been_created(): void
    {
        $user_username = fake()->unique()->userName();

        $this->postJson($this->url, [
            'username' => $user_username,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $user_exists = User::where('username', $user_username)->exists();

        $this->assertTrue($user_exists);
    }

    public function test_user_has_the_user_role(): void
    {
        $user_username = fake()->unique()->userName();

        $this->postJson($this->url, [
            'username' => $user_username,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $user_with_user_role_exists = User::role('user')->where('username', $user_username)->exists();

        $this->assertTrue($user_with_user_role_exists);
    }

    public function test_profile_has_been_created(): void
    {
        $user_username = fake()->unique()->userName();

        $this->postJson($this->url, [
            'username' => $user_username,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $user = User::firstWhere('username', $user_username);

        $this->assertNotNull($user->profile);
    }

    public function test_cart_has_been_created(): void
    {
        $user_username = fake()->unique()->userName();

        $this->postJson($this->url, [
            'username' => $user_username,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $user = User::where('username', $user_username)->first();

        $cart_exists = $user->cart()->exists();

        $this->assertTrue($cart_exists);
    }

    public function test_whish_list_has_been_created(): void
    {
        $user_username = fake()->unique()->userName();

        $this->postJson($this->url, [
            'username' => $user_username,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => fake()->unique()->email(),
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $user = User::where('username', $user_username)->first();

        $whish_list_exists = $user->whishList()->exists();

        $this->assertTrue($whish_list_exists);
    }

    public function test_send_successful_user_registration_email(): void
    {
        Mail::fake();

        $user_email = fake()->unique()->email();

        $this->postJson($this->url, [
            'username' => fake()->unique()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->unique()->numerify('###-###-###'),
            'email' => $user_email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        Mail::assertQueued(
            SuccessfulUserRegistrationEmail::class,
            function (SuccessfulUserRegistrationEmail $mail) use ($user_email) {
                return
                    $mail->hasTo($user_email) &&
                    $mail->hasSubject('Successful Registration') &&
                    $mail->hasFrom(env('MAIL_FROM_ADDRESS'));
            }
        );
    }
}
