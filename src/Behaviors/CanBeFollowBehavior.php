<?php

namespace SebastianKennedy\LaravelFollow\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait CanBeFollowBehavior
{
    public function follows()
    {
        return $this->morphMany(config('follow.model'), config('follow.morph_to_name'));
    }

    public function isFollowedBy(Model $model)
    {
        return ($this->relationLoaded('follows') ? $this->follows : $this->follows())
                ->where(config('follow.foreign_morph_to_id'), $model->getKey())
                ->where(config('follow.foreign_morph_to_type'), $model->getMorphClass())
                ->count() > 0;
    }

    public function followers()
    {
    }
}
