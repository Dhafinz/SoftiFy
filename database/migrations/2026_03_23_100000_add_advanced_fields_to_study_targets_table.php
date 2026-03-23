<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_targets', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('current_hours');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('status', 20)->default('active')->after('end_date');

            $table->index('status');
            $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('study_targets', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['end_date']);
            $table->dropColumn(['start_date', 'end_date', 'status']);
        });
    }
};
