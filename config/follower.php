<?php

return [
    'model' => '',
    'table_name' => 'follows',
    'morph_name' => 'followable',
    'morph_id' => 'followable_id',
    'morph_type' => 'followable_type',
    'foreign_morph_name' => 'follower',
    'foreign_morph_id' => 'follower_id',
    'foreign_morph_type' => 'follower_type',
];