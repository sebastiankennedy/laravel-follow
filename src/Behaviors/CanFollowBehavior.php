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
use Illuminate\Support\Collection;

trait CanFollowBehavior
{
    public function followings()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('follow.table_name'),
            config('follow.follower_key'),
            config('follow.following_key')
        );
    }

    public function follows()
    {
        return $this->hasMany(
            config('follow.model'),
            config('follow.follower_key'),
            $this->getKeyName()
        );
    }

    public function hasFollowed(Model $user)
    {
        if ($this->relationLoaded('followings')) {
            return $this->followings->contains($user);
        }

        return ($this->relationLoaded('follows') ? $this->follows : $this->follows())
                ->where(config('follow.following_key'), $user->getKey())
                ->count() > 0;
    }

    public function follow(Model $user)
    {
        if (!$this->hasFollowed($user)) {
            $follow = app(config('follow.model'));
            $follow->{config('follow.follower_key')} = $this->getKey();
            $follow->{config('follow.following_key')} = $user->getKey();
            $this->follows()->save($follow);
            $this->refresh();

            return $follow;
        }

        return null;
    }

    public function followMany(Collection $collection)
    {
        $collection->each(
            function (Model $user) {
                $this->follow($user);
            }
        );

        return $this->followings;
    }

    public function unFollow(Model $user)
    {
        $relation = $this->follows()
            ->where(config('follow.follower_key'), $this->getKey())
            ->where(config('follow.following_key'), $user->getKey())
            ->first();

        if ($relation) {
            $result = $relation->delete();
            $this->refresh();

            return $result;
        }

        return null;
    }

    public function unFollowMany(Collection $collection)
    {
        $collection->each(
            function (Model $user) {
                $this->unFollow($user);
            }
        );

        return $this->followings;
    }

    public function toggleFollow(Model $user)
    {
        return $this->hasFollowed($user) ? $this->unFollow($user) : $this->follow($user);
    }
}
