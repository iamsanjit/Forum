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

        $response = $this->post($this->thread->path() . '/replies', $reply->toArray());
        
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_valid_reply_body_is_required()
    {
        $this->signIn();

        $reply = make(Reply::class, ['body' => null]);

        $this->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function an_unauthenticated_user_can_not_reply_to_thread()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();
        $this->post($this->thread->path() . '/replies', []);
    }

    /** @test */
    public function an_unauthorized_user_can_not_delete_a_thread()  
    {
        // $this->withoutExceptionHandling();
        $reply = create(Reply::class);
        
        $this->delete("replies/{$reply->id}")
        ->assertRedirect('login');

        $this->signIn();

        $this->delete("replies/{$reply->id}")
            ->assertStatus(403);        

    }

    /** @test */
    public function an_authorized_user_can_delete_a_reply()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $reply = create(Reply::class, ['user_id' => $user->id]);

        $this->delete("replies/{$reply->id}");
        
        $this->assertDatabaseMissing('replies', $reply->toArray());
    }
}
