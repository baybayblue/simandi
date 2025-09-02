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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();

            // Kunci asing untuk relasi ke tabel lain
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Untuk mencatat admin yang memproses

            // Detail Transaksi
            $table->decimal('weight', 8, 2); // Berat cucian, misal: 5.50 kg
            $table->integer('total_price');  // Total biaya yang dihitung

            // Status & Tanggal
            $table->string('status')->default('Baru Masuk'); // Status: Baru Masuk, Proses, Selesai, Diambil
            $table->string('payment_status')->default('Belum Lunas'); // Status Pembayaran: Belum Lunas, Lunas
            $table->dateTime('completion_date')->nullable(); // Tanggal selesai dicuci
            $table->dateTime('pickup_date')->nullable();     // Tanggal diambil pelanggan

            // Kolom Tambahan
            $table->text('notes')->nullable(); // Catatan tambahan jika ada

            $table->timestamps(); // created_at (sebagai tanggal masuk) & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

