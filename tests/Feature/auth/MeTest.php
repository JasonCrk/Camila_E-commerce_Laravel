<?php

namespace Tests\Feature\auth;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

use Tymon\JWTAuth\Facades\JWTAuth;

use Database\Seeders\RoleSeeder;

use App\Models\User;
use App\Models\Profile;

use App\Http\Resources\UserProfileResource;

class MeTest extends TestCase
{
    use RefreshDatabase;

    private string $url;
    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $this->url = route('auth.me');

        $this->user = User::factory()->create();
        $this->user->assignRole('user');

        Profile::factory()->create(['user_id' => $this->user->id]);

        $this->token = 'Bearer ' . JWTAuth::fromUser($this->user);
    }

    /** @test */
    public function should_return_a_json_with_the_structure_of_UserProductResource(): void
    {
        $response = $this->withHeaders([
            'Authorization' => $this->token
        ])->getJson($this->url);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(
            (new UserProfileResource($this->user))->jsonSerialize()
        );
    }

    /** @test */
    public function should_return_an_error_is_the_authenticated_user_is_missing(): void
    {
        $response = $this->getJson($this->url);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}
