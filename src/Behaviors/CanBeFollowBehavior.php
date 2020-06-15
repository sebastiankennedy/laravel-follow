<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollow\Behaviors;

use Illuminate\Database\Eloquent\Model;

trait CanBeFollowBehavior
{
    public function follows()
    {
        return $this->hasMany(config('follow.model'), config('follow.following_key'), $this->getKeyName());
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
