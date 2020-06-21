## Laravel Follow

User follow feature for laravel application.

<p>
<a href="https://travis-ci.org/sebastiankennedy/laravel-follow"><img src="https://travis-ci.org/sebastiankennedy/laravel-follow.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-follow"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-follow/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-follow"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-follow/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/?branch=master"><img src="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/?branch=master"><img src="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/badges/coverage.png?b=master" alt="Code Coverage"></a>
<a href="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/?branch=master"><img src="https://scrutinizer-ci.com/g/sebastiankennedy/laravel-follow/badges/code-intelligence.svg?b=master" alt="Code Intelligence"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-follow"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-follow/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sebastian-kennedy/laravel-follow"><img src="https://poser.pugx.org/sebastian-kennedy/laravel-follow/license" alt="License"></a>
</p>

<p>
:busts_in_silhouette: User follow feature for laravel application.
</p>

## Version Matrix

Version | Laravel | PHP Version
---|---|---
1.x | 6.x | >= 7.3


## Installing

```shell
composer require sebastian-kennedy/laravel-follow -vvv
```

## Configuration

```shell
php artisan vendor:publish --provider="SebastianKennedy\\LaravelFollow\\FollowServiceProvider" --tag=config
```

## Migrations

```shell
php artisan vendor:publish --provider="SebastianKennedy\\LaravelFollow\\FollowServiceProvider" --tag=migrations
```

## Usage

#### Preparing the user model

To allow an user to be followed or to follow other users, the user models have to make usage of a trait.
```php
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
}
```

## CanFollowBehavior

#### Get list of followings
```php
$user = User::find(1);
$followings = $user->followings;
```

#### Get list of follow relationships
```php
$user = User::find(1);
$follows = $user->follows;
```

#### Determine if a user has followed the other user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->hasFollowed($user2);
```

#### Follow a User

```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->follow($user2);
```

#### Follow many users
```php
$user1 = User::find(1);
$users = User::whereIn('id', [2, 3, 4])->get();
$user1->followMany($users);
```

#### Special follow a user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->specialFollow($user2);
```

#### Unfollow a user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->unFollow($user2);
```

#### Unfollow many users
```php
$user1 = User::find(1);
$users = User::whereIn('id', [2, 3, 4])->get();
$user1->unFollowMany($users);
```

#### Cancel special follow a user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->cancelSpecialFollow($user2);
```

#### Toggle follow a user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->toggleFollow($user2);
```

## CanBeFollowBehavior

#### Get list of followers
```php
$user1 = User::find(1);
$user1->followers;
```

#### Get list of follow relationships
```php
$user1 = User::find(1);
$user1->follwable;
```

#### Determine if a user is followed By the other user
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->isFollowedBy($user2);
```

#### Accept a user follow request
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user2->follow($user1);
$user1->acceptFollow($user2);
```

#### Reject a user follow request
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->follow($user2);
$user2->rejectFollow($user1);
```

#### Remove a follower
```php
$user1 = User::find(1);
$user2 = User::find(2);
$user1->removeFollower($user2);
```

#### Remove many followers
```php
$user1 = User::find(1);
$users = User::whereIn('id', [2, 3, 4])->get();
$user1->removeManyFollowers($users);
```

## License

MIT