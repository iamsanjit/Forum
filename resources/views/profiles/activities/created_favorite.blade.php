 @component('profiles.activities.activity')
    @slot('title')
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $profileUser->name }} favorited a reply
        </a>
    @endSlot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endSlot
@endComponent