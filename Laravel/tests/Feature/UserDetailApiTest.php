<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDetailApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        $response = $this->actingAs($this->user)->json('GET', route('user.show', [
            'id' => $this->user->id,
        ]));

        $expected_data = [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'tweets_count' => $this->user->tweets_count,
            'followers_count' => $this->user->followers_count,
            'follows_count' => $this->user->follows_count,
            'followed_by_user' => $this->user->followed_by_user,
            'following_to_user' => $this->user->following_to_user,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($expected_data);
    }
}
