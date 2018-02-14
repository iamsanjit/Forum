<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Thread;
use App\Reply;
use App\Channel;
use App\User;
use Carbon\Carbon;

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

    /** @test */
    public function a_user_can_filter_thread_according_to_a_channel()
    {
        $this->withoutExceptionHandling();
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get("/threads/{$channel->slug}")
            ->assertStatus(200)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_thread_by_any_username()
    {
        $john = create(User::class, ['name' => 'John']);
                
        $threadByJohn = create(Thread::class, ['user_id' => $john->id]);
        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=' . $john->name)
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_thread_by_popularity()
    {
        $this->withoutExceptionHandling();
        $threadWithTwoReplies = create(Thread::class, ['created_at' => Carbon::parse('-7 Hour')]);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class, ['created_at' => Carbon::parse('-5 Hour')]);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
