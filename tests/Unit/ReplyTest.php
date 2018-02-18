<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function a_reply_has_an_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function a_reply_can_be_favorited_by_authenticated_user()
    {
        $this->signIn();

        $reply = create(Reply::class);
        $this->post("/replies/{$reply->id}/favorites");
        
        $this->assertTrue($reply->isFavorited());
    }
}
