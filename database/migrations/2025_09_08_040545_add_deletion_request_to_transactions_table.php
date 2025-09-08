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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('deletion_status')->nullable()->after('notes'); // Status: requested, approved, rejected
            $table->text('deletion_reason')->nullable()->after('deletion_status'); // Alasan dari pelanggan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['deletion_status', 'deletion_reason']);
        });
    }
};
