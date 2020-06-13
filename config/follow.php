<?php

use SebastianKennedy\LaravelFollower\Follow;

return [
    'model' => Follow::class,
    'table_name' => 'follows',
    'morph_to_many_name' => 'followable',
    'morph_to_many_id' => 'followable_id',
    'morph_to_many_type' => 'followable_type',
    'foreign_morph_to_many_name' => 'follower',
    'foreign_morph_to_many_id' => 'follower_id',
    'foreign_morph_to_many_type' => 'follower_type',
];