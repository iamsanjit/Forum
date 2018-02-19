@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="page-header">
        <h2>
            {{$profileUser->name}}
            <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
        </h2>
    </div>

    @foreach($threads as $thread)
        <div class="panel panel-default">
            <div class="panel-heading level">
                {{ $thread->title }}
                <span>{{ $thread->created_at->diffForHumans() }}</span>
            </div>
            <div class="panel-body">
                {{ $thread->body }}
            </div>
        </div>
    @endforeach

    <div class="text-center">
        {{$threads->links()}}
    </div>


</div>
@endsection
