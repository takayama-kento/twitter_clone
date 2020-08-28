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
        factory(User::class, 5)->create();
        $this->user = User::first();
    }

    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        $response = $this->actingAs($this->user)->json('GET', route('users.index'));

        // 生成したユーザーデータを作成日降順で取得
        $users = User::All();

        // data項目の期待値
        $expected_data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        })
        ->all();

        $response->assertStatus(200)
            // レスポンスJSONのdata項目に含まれる要素が5つであること
            ->assertJsonCount(5, 'data')
            // レスポンスJSONのdata項目が期待値と合致すること
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
