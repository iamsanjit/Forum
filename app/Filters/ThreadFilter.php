<?php

namespace App\Filters;

use App\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by'];

    /**
     * Filter the threads by given username
     */
    public function by($query)
    {
        $user = User::where(['name' => $this->request->get('by')])->firstOrFail();
        return $query->where('user_id', $user->id);
    }
}
