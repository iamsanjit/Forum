<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;
use App\Channel;
use App\User;
use App\Reply;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_thread()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
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

    /** @test */
    public function a_valid_title_is_required()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_valid_body_is_required()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_valid_channel_id_is_required()
    {
        $channel = create(Channel::class);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_user_can_not_delete_a_thread()
    {
        $thread = create(Thread::class);

        $this->delete('/threads/' . $thread->id)
            ->assertRedirect('login');

        $this->signIn();

        $this->delete('/threads/' . $thread->id)
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_thread()
    {
        $user = $this->signIn();
        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->delete('/threads/' . $thread->id)
            ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', ['thread_id' => $thread->id]);
    }

    /** @test */
    public function super_user_can_delete_any_thread()
    {
        $user = create(User::class, ['name' => 'Jane Doe']);
        $this->signIn($user);
        $thread = create(Thread::class);

        $this->delete('/threads/' . $thread->id)
            ->assertRedirect('/threads');

        $this->assertDatabaseMissing('threads', ['thread_id' => $thread->id]);
    }

    /** @test */
    public function replies_associate_with_thread_delete_along_with_thread()
    {
        $user = $this->signIn();

        $thread = create(Thread::class, ['user_id' => $user->id]);
        $reply = create(Reply::class, ['thread_id' => $thread]);

        $this->delete('/threads/' . $thread->id)
            ->assertRedirect('/threads');

        $this->assertEquals(0, $thread->replies()->count());
    }

    protected function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
