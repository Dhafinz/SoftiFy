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
        Schema::table('public_messages', function (Blueprint $table) {
            $table->string('type', 20)->default('chat')->after('message');
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_messages', function (Blueprint $table) {
            $table->dropIndex(['type', 'created_at']);
            $table->dropColumn('type');
        });
    }
};
