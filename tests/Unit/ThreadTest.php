<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    protected function setUp()
    {
        parent::setUp();
        
        $this->thread = factory(Thread::class)->create();
    }

    /** @test */
    public function a_thread_can_have_many_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->assertInstanceOf(Reply::class, $this->thread->replies->first());
        $this->assertEquals(1, $this->thread->replies->count());
    }

    /** @test */
    public function a_thread_has_an_owner()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_reply()
    {
        $reply = factory(Reply::class)->make();

        $this->thread->addReply($reply->toArray());

        $this->assertCount(1, $this->thread->replies);
        $this->assertInstanceOf(Reply::class, $this->thread->replies->first());
    }
}
