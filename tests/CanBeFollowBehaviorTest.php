<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace SebastianKennedy\LaravelFollow\Tests;

use Illuminate\Support\Collection;

class CanBeFollowBehaviorTest extends LaravelFollowTest
{
    public function testFollowers()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user2->follow($user1);
        $user3->follow($user1);
        $user4->follow($user1);
        $this->assertSame(3, $user1->followers->count());
        $this->assertInstanceOf(Collection::class, $user1->followers);
    }

    public function testFollowable()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user2->follow($user1);
        $user3->follow($user1);
        $user4->follow($user1);
        $this->assertSame(3, $user1->followable->count());
        $this->assertInstanceOf(Collection::class, $user1->followable);
    }

    public function testIsFollowedBy()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user2->follow($user1);
        $this->assertTrue($user1->isFollowedBy($user2));

        $user3->follow($user1);
        $this->assertSame(2, $user1->followable->count());
        $this->assertTrue($user1->isFollowedBy($user3));

        $user4->follow($user1);
        $this->assertSame(3, $user1->followers->count());
        $this->assertTrue($user1->isFollowedBy($user4));
    }

    public function testAcceptFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);

        $this->assertNull($user1->acceptFollow($user2));

        $user1->follow($user2);
        $this->assertTrue($user2->acceptFollow($user1));
    }

    public function testRejectFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);

        $this->assertNull($user1->rejectFollow($user2));

        $user1->follow($user2);
        $this->assertTrue($user2->rejectFollow($user1));
    }

    public function testRemoveFollower()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);

        $this->assertNull($user2->removeFollower($user1));

        $user1->follow($user2);
        $this->assertTrue($user2->removeFollower($user1));
    }

    public function testRemoveManyFollowers()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user2->follow($user1);
        $user3->follow($user1);
        $user4->follow($user1);
        $this->assertSame(3, $user1->followers->count());

        $user1->removeManyFollowers(collect([$user2, $user3, $user4]));
        $this->assertSame(0, $user1->followers->count());
    }
}
