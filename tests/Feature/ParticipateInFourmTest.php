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

        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    public function an_authenticated_user_can_reply_for_thread()
    {
        $this->withoutExceptionHandling();

        $this->be(factory(User::class)->create());

        $reply = factory(Reply::class)->make();

        $response = $this->post("threads/{$this->thread->id}/replies", $reply->toArray());
        $response->assertStatus(200);
        
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
