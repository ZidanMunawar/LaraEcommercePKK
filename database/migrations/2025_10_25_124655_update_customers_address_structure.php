<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            // Tambah kolom terpisah untuk provinsi, kabupaten, kecamatan, kelurahan
            $table->string('province_code', 10)->nullable()->after('alamat');
            $table->string('province_name', 100)->nullable()->after('province_code');
            $table->string('regency_code', 10)->nullable()->after('province_name');
            $table->string('regency_name', 100)->nullable()->after('regency_code');
            $table->string('district_code', 10)->nullable()->after('regency_name');
            $table->string('district_name', 100)->nullable()->after('district_code');
            $table->string('village_code', 15)->nullable()->after('district_name');
            $table->string('village_name', 100)->nullable()->after('village_code');
            $table->string('postal_code', 10)->nullable()->after('village_name');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'province_code',
                'province_name',
                'regency_code',
                'regency_name',
                'district_code',
                'district_name',
                'village_code',
                'village_name',
                'postal_code'
            ]);
        });
    }
};
