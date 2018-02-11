@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $thread->title }}
                    </div>
                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
            </div>

            @foreach ($thread->replies as $reply)
                @include ('threads.thread')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea
                            class="form-control"
                            name="body"
                            id="body"
                            rows="4"
                            placeholder="have to say something?"
                        ></textarea>
                    </div>
                    <input type="submit" value="Reply">
                </form>
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in discussion.</p>
    @endif
</div>
@endsection
