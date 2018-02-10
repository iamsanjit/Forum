<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Thread;
use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Auth\AuthenticationException;

class ParticipateInFourmTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $thread;

    protected function setUp()
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function an_authenticated_user_can_reply_for_thread()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = make(Reply::class);

        $response = $this->post("threads/{$this->thread->id}/replies", $reply->toArray());
        
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function an_unauthenticated_user_can_not_reply_to_thread()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();
        $this->post('threads/1/replies', []);
    }
}
