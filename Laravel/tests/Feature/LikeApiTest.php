<?php

namespace Tests\Feature;

use App\User;
use App\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Tweet::class)->create();
        $this->tweet = Tweet::first();
    }

    /**
     * @test
     */
    public function should_いいねを追加できる()
    {
        $response = $this->actingAs($this->user)->json('PUT', route('tweet.like', [
            'tweet_id' => $this->tweet->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'tweet_id' => $this->tweet->id,
            ]);
        
        $this->assertEquals(1, $this->tweet->likes()->count());
    }

    /**
     * @test
     */
    public function should_2回同じtweetにいいねしても1個しかいいねがつかない()
    {
        $this->actingAs($this->user)->json('PUT', route('tweet.like', ['tweet_id' => $this->tweet->id]));
        $this->actingAs($this->user)->json('PUT', route('tweet.like', ['tweet_id' => $this->tweet->id]));

        $this->assertEquals(1, $this->tweet->likes()->count());
    }

    /**
     * @test
     */
    public function should_いいねを解除できる()
    {
        $this->actingAs($this->user)->json('PUT', route('tweet.like', [
            'tweet_id' => $this->tweet->id,
        ]));

        $response = $this->actingAs($this->user)->json('DELETE', route('tweet.unlike', [
            'tweet_id' => $this->tweet->id,
        ]));

        $this->assertEquals(0, $this->tweet->likes()->count());
    }
}
