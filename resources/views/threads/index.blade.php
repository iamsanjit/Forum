@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Threads
                </div> 
                <div class="panel-body">
                    @foreach($threads as $thread)
                        <div class="level">
                            <h5>
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            </h5>
                            <strong><a href="{{ $thread->path()}}">{{ $thread->formatted_replies }}</a></strong>    
                        </div>
                            {{ $thread->body }}
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
