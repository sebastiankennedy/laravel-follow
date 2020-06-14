<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollow;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Follow
 *
 * @package SebastianKennedy\LaravelFollow
 */
class Follow extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => FollowedEvent::class,
        'deleted' => UnFollowedEvent::class,
    ];

    /**
     * @return MorphTo
     */
    public function follower()
    {
        return $this->morphTo(config('follow.foreign_morph_to_name'));
    }

    /**
     * @return MorphTo
     */
    public function following()
    {
        return $this->morphTo(config('follow.morph_to_name'));
    }
}
