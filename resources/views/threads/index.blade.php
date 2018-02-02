@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @foreach($threads as $thread)
                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        <br>
                        {{ $thread->body }}
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
