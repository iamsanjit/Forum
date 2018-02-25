<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
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
