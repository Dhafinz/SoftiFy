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
        Schema::table('users', function (Blueprint $table) {
            $table->string('class_level')->nullable()->after('email');
            $table->string('learning_goal')->nullable()->after('class_level');
            $table->unsignedInteger('current_streak')->default(0)->after('remember_token');
            $table->unsignedTinyInteger('grace_used_month')->default(0)->after('current_streak');
            $table->string('grace_month', 7)->nullable()->after('grace_used_month');
            $table->date('streak_calculated_at')->nullable()->after('grace_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'class_level',
                'learning_goal',
                'current_streak',
                'grace_used_month',
                'grace_month',
                'streak_calculated_at',
            ]);
        });
    }
};
