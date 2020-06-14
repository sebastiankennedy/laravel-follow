<?php

/*
 * This file is part of the sebastian-kennedy/laravel-follow.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateFollowsTable.
 */
class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            config('follow.table_name'),
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger(config('follow.foreign_morph_to_many_id'));
                $table->string(config('follow.foreign_morph_to_many_type'));
                $table->unsignedBigInteger(config('follow.morph_to_many_id'));
                $table->string(config('follow.morph_to_many_type'));
                $table->timestamp('accepted_at')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->timestamp('special_followed_at')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index([config('follow.morph_to_many_id'), config('follow.morph_to_many_type')]);
                $table->index([config('follow.foreign_morph_to_many_id'), config('follow.foreign_morph_to_many_type')]);
            }
        );
    }

    /**
     * Rollback the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('follow.table_name'));
    }
}
