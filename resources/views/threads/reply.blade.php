<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        
        @can('update', $reply)
            <div class="panel-footer flex">

                <button class="btn btn-sm btn-secondary mr-1" @click="editing = true">Edit</button>

                <form action="{{ route('replies.destroy', [$reply]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        @endCan
    </div>
</reply>