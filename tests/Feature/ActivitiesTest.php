<?php 

namespace Tests\Feature;

use App\Thread;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Activity;

class ActivitiesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_does_not_record_activity_for_guest()
    {
        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('login');

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function it_records_the_activity_when_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($thread->id, $activity->subject->id);
    }

    /** @test */
    public function it_records_the_activity_when_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => Reply::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($reply->id, $activity->subject->id);
    }
}
