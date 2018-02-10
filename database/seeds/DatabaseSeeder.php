<?php

use Illuminate\Database\Seeder;
use App\Thread;
use App\Reply;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = factory(Thread::class, 50)->create();
        
        foreach ($threads as $thread) {
            factory(Reply::class, 10)->create(['thread_id' => $thread->id]);
        }

        factory(User::class, 1)->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => bcrypt('password')
        ]);
    }
}
