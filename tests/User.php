<?php

namespace SebastianKennedy\LaravelFollow\Tests;

use Illuminate\Database\Eloquent\Model;
use SebastianKennedy\LaravelFollow\Behaviors\CanBeFollowBehavior;
use SebastianKennedy\LaravelFollow\Behaviors\CanFollowBehavior;

/**
 * Class User
 *
 * @package SebastianKennedy\LaravelFollow\Tests
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