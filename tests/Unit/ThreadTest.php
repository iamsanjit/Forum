<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Reply;

class ThreadTest extends TestCase
{
    /** @test */
    public function a_thread_can_have_many_replies()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);

        $this->assertInstanceOf(Reply::class, $thread->replies->first());
        $this->assertEquals(1, $thread->replies->count());
    }
}
