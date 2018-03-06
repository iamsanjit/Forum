<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading level">
        <div>
            <a href="#">
                {{ $reply->owner->name }}
            </a> said {{ $reply->created_at->diffForHumans() }} ...
        </div>
        <form method = "POST" action="{{ '/replies/' . $reply->id . '/favorites' }}">
            {{ csrf_field() }}

            <button type="submit" {{ $reply->isFavorited() ? 'disabled' : ''}}>
                {{ $reply->favorites_count }} Favorite
            </button>
        </form>
    </div>
    <div class="panel-body">
        {{ $reply->body }}
    </div>
    
    @can('update', $reply)
        <div class="panel-footer">
            <form action="{{ route('replies.destroy', [$reply]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    @endCan
</div>