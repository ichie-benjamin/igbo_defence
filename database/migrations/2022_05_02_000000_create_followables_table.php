<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowablesTable extends Migration
{
    public function up()
    {
        Schema::create(config('follow.followables_table', 'followables'), function (Blueprint $table) {
            $table->id();

            $table->uuid('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuidMorphs('followable');

            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index(['followable_type', 'accepted_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('follow.followables_table', 'followables'));
    }
}
