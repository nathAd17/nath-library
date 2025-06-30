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
        Schema::create('gamification_activities', function (Blueprint $table) {
            $table->id();
            $table->enum('activity_type', ['pinjam', 'pengembalian', 'terlambat', 'review']);
            $table->integer('point_reward');
            $table->foreignId('badge_id')->nullable()->constrained('badges')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('gamification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('activity_type', ['pinjam', 'pengembalian', 'terlambat', 'review']);
            $table->integer('points_earned');
            $table->text('description');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamification_activities');
        Schema::dropIfExists('gamification_logs');
    }
};
