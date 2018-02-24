<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(function ($builder) {
            return $builder->withCount('replies');
        });

        self::deleting(function ($thread) {
           $thread->replies()->delete();
        });

        self::created(function($thread) {
            $thread->recordActivity('created');
        });

    }

    protected function recordActivity($event)
    {
        if (Auth::check()) {
            Activity::create([
                'type' =>  $event . '_' . strtolower(class_basename($this)),
                'user_id' => auth()->id(),
                'subject_id' => $this->id,
                'subject_type' => get_class($this)
            ]);
        }
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function getFormattedRepliesAttribute()
    {
        return $this->replies_count . ' ' .str_plural('reply', $this->replies_count);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
