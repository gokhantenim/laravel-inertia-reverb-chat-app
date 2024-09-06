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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('room_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->enum('type', ['normal', 'admin']);
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_user');
        Schema::dropIfExists('messages');
    }
};
