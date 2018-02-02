<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function a_user_can_see_all_threads()
    {
        $this->get('threads');
        $this->assertStatusCode(200);
    }
}
