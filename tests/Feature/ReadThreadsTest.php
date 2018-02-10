<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $thread;

    protected function setUp()
    {
        parent::setUp();
        
        $this->thread = create(Thread::class);
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
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_the_replies_associated_with_threads()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $this->withoutExceptionHandling();

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
