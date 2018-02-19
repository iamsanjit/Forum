<?php 

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function user_has_a_profile()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class, ['name' => 'Jane Doe']);

        $this->get('profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    public function it_contains_thread_belongs_to_profile_user()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);
        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get('profiles/' . $user->name)
            ->assertSee($thread->title);
    }
}
