<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'model' => SebastianKennedy\LaravelFollow\Follow::class,
    'table_name' => 'follows',
    'follower_key' => 'follower_id',
    'following_key' => 'following_id',
];
