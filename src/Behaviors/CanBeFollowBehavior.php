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

trait CanBeFollowBehavior
{
    public function followers()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('follow.table_name'),
            config('follow.following_key'),
            config('follow.follower_key')
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

    public function isFollowedBy(Model $user)
    {
        if ($this->relationLoaded('followers')) {
            return $this->followers->contains($user);
        }

        return ($this->relationLoaded('followable') ? $this->followable : $this->followable())
                ->where(config('follow.follower_key'), $user->getKey())
                ->count() > 0;
    }

    public function acceptFollow(Model $user)
    {
        return $this->followable()
            ->where(config('follow.follower_key'), $user->getKey())
            ->update(['accepted_at' => now()]);
    }

    public function rejectFollow(Model $user)
    {
        return $this->followable()
            ->where(config('follow.follower_key'), $user->getKey())
            ->update(['rejected_at' => now()]);
    }

    public function removeFollower(Model $user)
    {
        $relation = $this->followable()
            ->where(config('follow.follower_key'), $user->getKey())
            ->where(config('follow.following_key'), $this->getKey())
            ->first();

        if ($relation) {
            $result = $relation->delete();
            $this->refresh();

            return $result;
        }

        return null;
    }

    public function removeManyFollowers(Collection $collection)
    {
        $collection->each(
            function (Model $user) {
                $this->removeFollower($user);
            }
        );

        return $this->followers;
    }
}
