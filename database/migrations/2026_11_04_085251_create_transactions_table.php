<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained('users'); // Relasi ke kasir yang login
            $table->integer('total_price');                     // Mengganti total_amount agar sesuai dengan controller
            $table->integer('pay');                             // Uang yang dibayarkan
            $table->integer('change');                          // Uang kembalian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
