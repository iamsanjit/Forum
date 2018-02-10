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
</div>
@endsection
