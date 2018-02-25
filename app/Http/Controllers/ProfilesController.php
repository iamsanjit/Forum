<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activites = $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('y-m-d');
        });

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activites
        ]);
    }
}
