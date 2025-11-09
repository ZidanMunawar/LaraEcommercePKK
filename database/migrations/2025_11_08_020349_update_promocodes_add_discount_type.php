<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            // Tambah column discount_type (percentage atau fixed)
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed')->after('discount');

            // Tambah kolom min_purchase (minimal pembelian)
            $table->decimal('min_purchase', 10, 2)->default(0)->after('discount_type');
        });
    }

    public function down()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'min_purchase']);
        });
    }
};
