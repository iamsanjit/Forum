 @component('profiles.activities.activity')
    @slot('title')
        {{ $activity->subject->creator  ->name }} posted to
       <a href="{{ $activity->subject->path() }}">"{{ $activity->subject->title }}"</a>
    @endSlot
    @slot('body')
        {{ $activity->subject->body }}
    @endSlot
@endComponent