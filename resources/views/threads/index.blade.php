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
                                by <a href="#">{{ $thread->creator->name }}</a>
                            </h5>
                            <strong>{{ $thread->formatted_replies }}</strong>    
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
