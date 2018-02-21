<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;
use Illuminate\Support\Facades\Auth;
use App\Filters\ThreadFilter;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Channel $channel, ThreadFilter $filters)
    {
        if ($channel->exists) {
            $threads = $channel->threads();
        } else {
            $threads = new Thread();
        }

        $threads = $threads->filter($filters)->latest()->get();

        if (request()->wantsJson()) {
            return $threads;
        }

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
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path());
    }

    public function destroy(Thread $thread)
    {
        if (!Auth::user()->can('update', $thread)) {
            abort(403, 'You are not authorized for this action.');
        }
        
        $thread->delete();

        return redirect('threads');
    }
}
