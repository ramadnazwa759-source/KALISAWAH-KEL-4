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
        Schema::create('pemasukan', function (Blueprint $table) {

            $table->id();

            // nullable karena tidak semua pemasukan dari booking
            $table->foreignId('booking_id')
                ->nullable()
                ->constrained('booking')
                ->nullOnDelete();

            $table->string('sumber_pemasukan');
            // contoh:
            // Booking Rafting
            // Penjualan Merchandise
            // Sewa Aula
            // dll

            $table->decimal('jumlah_uang', 12, 2);

            $table->date('tanggal_pemasukan');

            $table->text('keterangan')->nullable();

            $table->string('dicatat_oleh');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
