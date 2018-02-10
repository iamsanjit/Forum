<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;
use Illuminate\Auth\AuthenticationException;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_thread()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = make(Thread::class);

        $this->post('threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guest_can_not_create_thread()
    {
        $this->get(route('threads.create'))
            ->assertRedirect('login');
    
        $this->post('/threads')
            ->assertRedirect('login');
    }
}
