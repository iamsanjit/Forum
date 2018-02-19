<div class="panel panel-default">
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
</div>