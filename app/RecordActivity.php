<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        self::created(function ($thread) {
            $thread->recordActivity('created');
        });
    }

    protected function recordActivity($event)
    {
        if (auth()->check()) {
            $this->activity()->create([
                'type' =>  $this->getActivityType($event),
                'user_id' => auth()->id(),
            ]);
        }
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower(class_basename($this));
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
