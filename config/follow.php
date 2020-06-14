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
    'morph_to_many_name' => 'following',
    'morph_to_many_id' => 'following_id',
    'morph_to_many_type' => 'following_type',
    'foreign_morph_to_many_name' => 'follower',
    'foreign_morph_to_many_id' => 'follower_id',
    'foreign_morph_to_many_type' => 'follower_type',
];
