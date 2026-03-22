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
        Schema::create('steam_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('steam_appid');
            $table->integer('total_minutes');
            $table->dateTime('snapped_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_snapshots');
    }
};
