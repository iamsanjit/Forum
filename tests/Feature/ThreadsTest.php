<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Reply;

class ThreadsTest extends TestCase
{
    protected $thread;

    protected function setUp()
    {
        parent::setUp();
        
        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    public function a_user_can_see_all_threads()
    {
        $response = $this->get('threads');
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_see_single_thread()
    {
        $response = $this->get('threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_the_replies_associated_with_threads()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->withoutExceptionHandling();

        $this->get("threads/{$this->thread->id}")
            ->assertSee($reply->body);
    }
}
