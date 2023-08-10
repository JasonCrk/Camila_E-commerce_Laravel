<?php

namespace Tests\Feature\auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use Illuminate\Http\Response;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private string $url;
    private string $email;
    private string $password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->url = route('auth.login');

        $this->email = fake()->email();
        $this->password = fake()->password(8);

        User::factory()->create([
            'password' => $this->password,
            'email' => $this->email
        ]);
    }

    public function test_returns_a_successful_message_response(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['message' => 'Login successful']);
    }

    public function test_return_the_token(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertIsString($response->json('token'));
    }

    public function test_returns_the_bearer_token_type(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['token_type' => 'bearer']);
    }

    public function test_returns_the_expire_in_property(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->email,
            'password' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertIsInt(intval($response->json('expire_in')));
    }

    public function test_returns_an_error_response_if_the_credentials_are_wrong(): void
    {
        $response = $this->postJson($this->url, [
            'email' => fake()->email(),
            'password' => fake()->password()
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'message' => 'Email or password are wrong'
        ]);
    }
}
