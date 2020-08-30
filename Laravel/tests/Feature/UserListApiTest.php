<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserListApiTest extends TestCase
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
        factory(User::class, 9)->create();
        $response = $this->actingAs($this->user)->json('GET', route('user.index'));

        $users = User::get();

        // data項目の期待値
        $expected_data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'followed_by_user' => $user->followed_by_user,
                'following_to_user' => $user->following_to_user,
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
