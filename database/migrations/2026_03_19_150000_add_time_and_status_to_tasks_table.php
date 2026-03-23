<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->time('time')->nullable()->after('due_date');
            $table->string('status', 20)->default('pending')->after('time');
        });

        DB::table('tasks')
            ->where('is_done', true)
            ->update(['status' => 'done']);
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['time', 'status']);
        });
    }
};
