 <div class="panel panel-default">
        <div class="panel-heading level">
            {{ $thread->creator->name }} posted: {{ $thread->title }}
            
            @can('update', $thread)
                <form method="POST" action="{{ '/threads/' . $thread->id }}">

                    {{ csrf_field() }}

                    {{ method_field('DELETE') }}
                    
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            @endcan
        </div>
        <div class="panel-body">
            {{ $thread->body }}
        </div>
</div>