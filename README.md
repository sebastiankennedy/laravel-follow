## >Laravel Follow

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

#### Follow

## License

MIT