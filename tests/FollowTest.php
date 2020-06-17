<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollow\Tests;

class FollowTest extends LaravelFollowTest
{
    public function testFollower()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $follow = $user1->follow($user2);
        $this->assertSame('User 1', $follow->follower->name);
    }

    public function testFollowing()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $follow = $user1->follow($user2);
        $this->assertSame('User 2', $follow->following->name);
    }
}
