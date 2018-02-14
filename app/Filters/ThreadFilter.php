<?php

namespace App\Filters;

use App\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter the threads by given username
     */
    public function by($username)
    {
        $user = User::where(['name' => $username])->firstOrFail();
        $this->builder->where('user_id', $user->id);
    }

    public function popular()
    {
        $this->builder->orderBy('replies_count', 'DESC');
    }
}
