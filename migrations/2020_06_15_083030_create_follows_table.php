<?php

/*
 * This file is part of the sebastian-kennedy/laravel-like.
 *
 * (c) SebastianKennedy <sebastiankennedy@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateFollowsTable
 */
class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            config('follower.table_name'),
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('follower_id');
                $table->string('follower_type');
                $table->string('followable_id');
                $table->string('followable_type');
                $table->timestamp('accepted_at')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Rollback the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('follower.table_name'));
    }
}
