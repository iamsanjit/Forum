<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class ThreadsTest extends TestCase
{
    /** @test */
    public function a_user_can_see_all_threads()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('threads');
        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_see_single_thread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
