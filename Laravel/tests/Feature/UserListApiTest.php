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
        factory(User::class, 10)->create();
        $response = $this->actingAs($this->user)->json('GET', route('user.index'));

        $users = User::get();

        // data項目の期待値
        $expected_data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        })
        ->all();

        $response->assertStatus(200);
            // レスポンスJSONのdata項目が期待値と合致すること
            /**
             *->assertJsonFragment([
             *  "data" => $expected_data,
             *]); */
    }
}
