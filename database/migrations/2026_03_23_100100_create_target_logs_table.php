<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained('study_targets')->cascadeOnDelete();
            $table->unsignedInteger('added_hours');
            $table->text('note')->nullable();
            $table->date('date');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_logs');
    }
};
