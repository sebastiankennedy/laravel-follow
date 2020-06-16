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
    public function followers()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('follow.table_name'),
            config('follow.following_id'),
            config('follow.follower_id')
        );
    }

    public function followable()
    {
        return $this->hasMany(
            config('follow.model'),
            config('follow.following_key'),
            $this->getKeyName()
        );
    }

    public function isFollowedBy(Model $model)
    {
        return ($this->relationLoaded('followable') ? $this->followable : $this->followable())
                ->where(config('follow.follower_key'), $model->getKey())
                ->count() > 0;
    }
}
