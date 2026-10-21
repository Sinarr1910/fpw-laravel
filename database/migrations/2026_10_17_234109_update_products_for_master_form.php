<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. lepas foreign key supplier dulu supaya kolomnya bisa diubah
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });

        // 2. tambah kolom code & unit, jadikan supplier_id boleh kosong
        Schema::table('products', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->unique()->after('category_id');
            $table->string('unit', 20)->default('pcs')->after('name');
            $table->unsignedBigInteger('supplier_id')->nullable()->change();
        });

        // 3. pasang kembali foreign key
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn(['code', 'unit']);
        });
    }
};
