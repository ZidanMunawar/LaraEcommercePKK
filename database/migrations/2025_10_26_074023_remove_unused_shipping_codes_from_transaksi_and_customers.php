<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove from transaksi table
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_province_code',
                'shipping_regency_code',
                'shipping_district_code',
                'shipping_village_code'
            ]);
        });

        // Remove from customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'province_code',
                'regency_code',
                'district_code',
                'village_code'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback transaksi table
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('shipping_province_code', 10)->nullable()->after('shipping_address');
            $table->string('shipping_regency_code', 10)->nullable()->after('shipping_province_name');
            $table->string('shipping_district_code', 10)->nullable()->after('shipping_regency_name');
            $table->string('shipping_village_code', 15)->nullable()->after('shipping_district_name');
        });

        // Rollback customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->string('province_code', 10)->nullable()->after('alamat');
            $table->string('regency_code', 10)->nullable()->after('province_name');
            $table->string('district_code', 10)->nullable()->after('regency_name');
            $table->string('village_code', 15)->nullable()->after('district_name');
        });
    }
};
