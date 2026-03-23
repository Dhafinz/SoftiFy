<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('premium_verification_email')->nullable()->after('premium_activated_at');
            $table->string('premium_payment_proof_path')->nullable()->after('premium_verification_email');
            $table->string('premium_verification_status', 20)->nullable()->after('premium_payment_proof_path');
            $table->timestamp('premium_payment_submitted_at')->nullable()->after('premium_verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'premium_verification_email',
                'premium_payment_proof_path',
                'premium_verification_status',
                'premium_payment_submitted_at',
            ]);
        });
    }
};
