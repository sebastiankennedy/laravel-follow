<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollow\Tests;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelFollow\Behaviors\CanBeFollowBehavior;
use SebastianKennedy\LaravelFollow\Behaviors\CanFollowBehavior;

/**
 * Class User.
 */
class User extends Model
{
    use CanFollowBehavior;
    use CanBeFollowBehavior;
    /**
     * @var array
     */
    protected $fillable = ['name'];
}
