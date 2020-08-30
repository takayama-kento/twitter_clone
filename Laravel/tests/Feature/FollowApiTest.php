<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->following_user = factory(User::class)->create();
        $this->followed_user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_フォローすることができる()
    {
        $response = $this->actingAs($this->following_user)
            ->json('PUT', route('user.follow', [
                'id' => $this->followed_user->id,
            ]));
        
        $response->assertStatus(200)
            ->assertJsonFragment([
                'user_id' => $this->followed_user->id,
            ]);
        
        $this->assertEquals(1, $this->followed_user->followers()->count());
    }
    
    /**
     * @test
     */
    public function should_フォローを解除することができる()
    {
        $response = $this->followed_user->followers()->attach($this->following_user->id);

        $response = $this->actingAs($this->following_user)
            ->json('DELETE', route('user.unfollow', [
                'id' => $this->followed_user->id,
            ]));
        
        $response->assertStatus(200)
                ->assertJsonFragment([
                    'user_id' => $this->followed_user->id,
                ]);
        
        $this->assertEquals(0, $this->followed_user->followers()->count());
    }
}
