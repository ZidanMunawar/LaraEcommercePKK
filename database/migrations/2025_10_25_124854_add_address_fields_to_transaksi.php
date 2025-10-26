<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Alamat pengiriman detail
            $table->string('shipping_name', 100)->nullable()->after('id_shipping_method');
            $table->string('shipping_phone', 20)->nullable()->after('shipping_name');
            $table->text('shipping_address')->nullable()->after('shipping_phone');
            $table->string('shipping_province_code', 10)->nullable()->after('shipping_address');
            $table->string('shipping_province_name', 100)->nullable()->after('shipping_province_code');
            $table->string('shipping_regency_code', 10)->nullable()->after('shipping_province_name');
            $table->string('shipping_regency_name', 100)->nullable()->after('shipping_regency_code');
            $table->string('shipping_district_code', 10)->nullable()->after('shipping_regency_name');
            $table->string('shipping_district_name', 100)->nullable()->after('shipping_district_code');
            $table->string('shipping_village_code', 15)->nullable()->after('shipping_district_name');
            $table->string('shipping_village_name', 100)->nullable()->after('shipping_village_code');
            $table->string('shipping_postal_code', 10)->nullable()->after('shipping_village_name');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_name',
                'shipping_phone',
                'shipping_address',
                'shipping_province_code',
                'shipping_province_name',
                'shipping_regency_code',
                'shipping_regency_name',
                'shipping_district_code',
                'shipping_district_name',
                'shipping_village_code',
                'shipping_village_name',
                'shipping_postal_code'
            ]);
        });
    }
};
