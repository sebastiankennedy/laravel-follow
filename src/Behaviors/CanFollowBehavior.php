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
        return $this->morphMany(config('follow.model'), config('follow.foreign_morph_to_name'));
    }

    public function hasFollowed(Model $model)
    {
        return ($this->relationLoaded('follows') ? $this->follows : $this->follows())
                ->where(config('follow.morph_to_id'), $model->getKey())
                ->where(config('follow.morph_to_type'), $model->getMorphClass())
                ->count() > 0;
    }

    public function follow(Model $model)
    {
        if (!$this->hasFollowed($model)) {
            $follow = app(config('follow.model'));
            $follow->{config('follow.morph_to_id')} = $model->getKey();
            $follow->{config('follow.morph_to_type')} = $model->getMorphClass();
            $follow->{config('follow.foreign_morph_to_id')} = $this->getKey();
            $follow->{config('follow.foreign_morph_to_type')} = $this->getMorphClass();

            return $this->follows()->save($follow);
        }

        return null;
    }

    public function unFollow(Model $model)
    {
        $relation = $this->follows()
            ->where(config('follow.morph_to_id'), $model->getKey())
            ->where(config('follow.morph_to_type'), $model->getMorphClass())
            ->where(config('follow.foreign_morph_to_id'), $this->getKey())
            ->where(config('follow.foreign_morph_to_type'), $this->getMorphClass())
            ->find();

        if ($relation) {
            return $relation->delete($relation);
        }

        return null;
    }

    public function toggleFollow(Model $model)
    {
        return $this->hasFollowed($model) ? $this->unFollow($model) : $this->follow($model);
    }
}
