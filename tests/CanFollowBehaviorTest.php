<?php

namespace SebastianKennedy\LaravelFollow\Tests;

use Illuminate\Support\Collection;
use SebastianKennedy\LaravelFollow\Follow;

class CanFollowBehaviorTest extends LaravelFollowTest
{
    public function testFollowings()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user1->follow($user2);
        $user1->follow($user3);

        $this->assertInstanceOf(Collection::class, $user1->followings);
        $this->assertSame(2, $user1->followings->count());
        foreach ($user1->followings as $following) {
            $this->assertInstanceOf(config('auth.providers.users.model'), $following);
        }
    }

    public function testFollows()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user1->follow($user2);
        $user1->follow($user3);


        $this->assertInstanceOf(Collection::class, $user1->follows);
        $this->assertSame(2, $user1->follows->count());
        foreach ($user1->follows as $follow) {
            $this->assertInstanceOf(Follow::class, $follow);
        }
    }

    public function testHasFollowed()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user1->follow($user2);
        $user1->follow($user3);
        $this->assertTrue($user1->hasFollowed($user2));
        $this->assertSame(2, $user1->follows->count());
        $this->assertTrue($user1->hasFollowed($user3));
        $user1->follow($user4);
        $this->assertSame(3, $user1->followings->count());
        $this->assertTrue($user1->hasFollowed($user4));
    }

    public function testFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);

        $this->assertInstanceOf(Follow::class, $user1->follow($user2));
        $this->assertNull($user1->follow($user2));
    }

    public function testFollowMany()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $followings = $user1->followMany(collect([$user2, $user3, $user4]));
        $this->assertInstanceOf(Collection::class, $followings);
        foreach ($followings as $following) {
            $this->assertInstanceOf(config('auth.providers.users.model'), $following);
        }
    }

    public function testSpecialFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);

        $user1->follow($user2);
        $this->assertTrue($user1->specialFollow($user2));
        $this->assertInstanceOf(Follow::class, $user1->specialFollow($user3));
    }

    public function testUnFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $user1->followMany(collect([$user2, $user3]));
        $this->assertTrue($user1->unFollow($user2));
        $this->assertSame(1, $user1->followings->count());
        $this->assertTrue($user1->unFollow($user3));
        $this->assertSame(0, $user1->followings->count());
        $this->assertNull($user1->unFollow($user4));
    }

    public function testUnFollowMany()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $user3 = User::create(['name' => 'User 3']);
        $user4 = User::create(['name' => 'User 4']);

        $followings = $user1->followMany(collect([$user2, $user3, $user4]));
        $user1->unFollowMany($followings);
        $this->assertSame(0, $user1->followings->count());
    }

    public function testCancelSpecialFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $this->assertNull($user1->cancelSpecialFollow($user2));
        $user1->specialFollow($user2);
        $this->assertTrue($user1->cancelSpecialFollow($user2));
    }

    public function testToggleFollow()
    {
        $user1 = User::create(['name' => 'User 1']);
        $user2 = User::create(['name' => 'User 2']);
        $this->assertInstanceOf(Follow::class, $user1->toggleFollow($user2));
        $this->assertTrue($user1->toggleFollow($user2));
    }
}