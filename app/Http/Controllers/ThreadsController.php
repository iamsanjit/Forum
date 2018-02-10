<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create');
    }

    public function index()
    {
        $threads = Thread::latest()->get();
        return view('threads.index', compact('threads'));
    }

    public function show($channel, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store()
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path());
    }
}
