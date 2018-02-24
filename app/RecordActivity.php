<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        foreach (self::getActivitiesToRecord() as $event) {
            self::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        if (auth()->guest()) {
            return;
        }
        $this->activity()->create([
            'type' =>  $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
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
