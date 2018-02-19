@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 ">

            <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $thread->creator->name }} posted: {{ $thread->title }}
                    </div>
                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
            </div>

            @foreach ($thread->replies as $reply)
                @include ('threads.reply')
            @endforeach

            @if (auth()->check())
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
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in discussion.</p>
            @endif

        </div>


        <div class="col-md-4">
            <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{$thread->created_at->diffForHumans()}}
                        and currenty have {{$thread->formatted_replies}}.
                    </div>
            </div>
        </div>

    </div>


</div>
@endsection
