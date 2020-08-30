<?php

namespace Tests\Feature;

use App\Tweet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetListApiTest extends TestCase
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
    public function should_正しいJSON構造を返却する()
    {
        factory(Tweet::class, 5)->create();

        $response = $this->actingAs($this->user)->json('GET', route('tweet.index'));
        $tweets = Tweet::with(['author'])->orderBy('created_at', 'desc')->get();

        $expected_data = $tweets->map(function ($tweet) {
            return [
                'id' => $tweet->id,
                'tweet' => $tweet->tweet,
                'author' => [
                    'id' => $tweet->author->id,
                    'name' => $tweet->author->name,
                ]
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
