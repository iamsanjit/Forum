<?php

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        if (! $this->favorites()->where('user_id', auth()->id())->exists()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function unfavorite()
    {
        $attrs = ['user_id' => auth()->id()];

        if ($this->favorites()->where($attrs)->exists()) {
            $this->favorites()->where($attrs)->get()->each->delete();
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
