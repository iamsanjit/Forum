<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Reply;
use Illuminate\Auth\AuthenticationException;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthorized_user_can_not_favorite_a_reply()
    {
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites")
            ->assertRedirect('login');

        $this->assertEquals(0, $reply->favorites()->count());
    }

    /** @test */
    public function an_authorized_user_can_favorite_a_reply()
    {
        $this->signIn();
        
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites")
            ->assertStatus(200);
        
        $this->assertEquals(1, $reply->favorites()->count());
    }
    
    /** @test */
    public function a_user_can_not_favorite_reply_twice()
    {
        $this->withoutExceptionHandling()->signIn();
        
        $reply = create(Reply::class);

        $this->post("/replies/{$reply->id}/favorites");
        $this->post("/replies/{$reply->id}/favorites");

        $this->assertEquals(1, $reply->fresh()->favorites()->count());
    }
}
