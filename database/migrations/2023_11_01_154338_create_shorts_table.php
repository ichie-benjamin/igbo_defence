<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shorts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('status')->default('active');
            $table->string('file')->nullable();
            $table->string('tags')->nullable();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shorts');
    }
};
