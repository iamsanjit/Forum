@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row">
        <div class="col-sm-8 col-">
            <div class="page-header">
                <h2>
                    {{$profileUser->name}}
                </h2>
            </div>

            @forelse($activities as $date => $activitiesGroup)
                <div class="page-header">{{$date}}</div>
                @foreach($activitiesGroup as $activity)
                    @if(view()->exists("profiles.activities.{$activity->type}"))
                        @include("profiles.activities.{$activity->type}")
                    @endIf
                @endforeach
            @empty
                <div class="text-center">No activity.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
