<?php

namespace App\Filters;

use App\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by'];

    /**
     * Filter the threads by given username
     */
    public function by($username)
    {
        $user = User::where(['name' => $username])->firstOrFail();
        return $this->query->where('user_id', $user->id);
    }
}
