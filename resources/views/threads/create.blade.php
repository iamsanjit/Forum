@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create new post
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('threads.store') }}">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title">Select channel</label>
                            <select class="form-control" name="channel_id" id="channel_id" required>
                                <option value="">Choose one ..</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea type="text" name="body" class="form-control" rows="5" required>{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Create">
                        </div>

                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection
