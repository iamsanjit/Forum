@extends('layouts.app')

@section('content')

<thread-view inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 ">

            @include('threads.thread')  

                <replies :data="{{ $thread->replies }}"></replies>

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
</thread-view>
@endsection
