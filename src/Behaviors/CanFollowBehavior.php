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

trait CanFollowBehavior
{
    public function follows()
    {
        return $this->hasMany(config('follow.model'), config('follow.follower_key'), $this->getKeyName());
    }

    public function hasFollowed(Model $model)
    {
        return ($this->relationLoaded('follows') ? $this->follows : $this->follows())
                ->where(config('follow.following_key'), $model->getKey())
                ->count() > 0;
    }

    public function follow(Model $user)
    {
        if (!$this->hasFollowed($user)) {
            $follow = app(config('follow.model'));
            $follow->{config('follow.follower_key')} = $this->getKey();
            $follow->{config('follow.following_key')} = $user->getKey();

            return $this->follows()->save($follow);
        }

        return null;
    }

    public function unFollow(Model $user)
    {
        $relation = $this->follows()
            ->where(config('follow.follower_key'), $this->getKey())
            ->where(config('follow.following_key'), $user->getKey())
            ->first();

        if ($relation) {
            return $relation->delete();
        }

        return null;
    }

    public function toggleFollow(Model $model)
    {
        return $this->hasFollowed($model) ? $this->unFollow($model) : $this->follow($model);
    }
}
