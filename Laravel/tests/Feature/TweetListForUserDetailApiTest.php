<?php

namespace Tests\Feature;

use App\User;
use App\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetListForUserDetailApiTest extends TestCase
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

        $response = $this->actingAs($this->user)->json('GET', route('user.tweets', [
            'id' => 2
        ]));

        $tweets = Tweet::where('user_id', 2)->with(['author'])->orderBy('created_at', 'desc')->get();

        $expected_data = $tweets->map(function ($tweet) {
            return [
                'id' => $tweet->id,
                'tweet' => $tweet->tweet,
                'author' => [
                    'id' => $tweet->author->id,
                    'name' => $tweet->author->name,
                    'tweets_count' => $tweet->author->tweets_count,
                    'followers_count' => $tweet->author->followers_count,
                    'follows_count' => $tweet->author->follows_count,
                    'followed_by_user' => $tweet->author->followed_by_user,
                    'following_to_user' => $tweet->author->following_to_user,
                ],
                'formatted_created_at' => $tweet->formatted_created_at,
            ];
        })
        ->all();

        $response->assertStatus(200)
            ->assertJsonFragment([
                "data" => $expected_data,
            ]);
    }
}
