 @component('profiles.activities.activity')
    @slot('title')
        {{ $activity->subject->owner->name }} replied to
       <a href="{{ $activity->subject->thread->path() }}">"{{ $activity->subject->thread->title }}"</a>
    @endSlot
    @slot('body')
        {{ $activity->subject->body }}
    @endSlot
@endComponent