<?php

namespace Tests\Feature;

use App\User;
use App\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TweetApiTest extends TestCase
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
        factory(Tweet::class)->create();

        $response = $this->actingAs($this->user)->json('GET', route('tweet.show', [
            'tweet_id' => 1,
        ]));

        $tweet = Tweet::where('id', 1)->with(['author'])->first();

        $expected_data = [
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
            'likes_count' => 0,
            'liked_by_user' => false,
        ];

        $response->assertStatus(200)
            ->assertJsonFragment($expected_data);
    }
}
