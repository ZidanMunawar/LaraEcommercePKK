<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Update existing data dulu (bulatkan decimal)
        DB::statement('UPDATE promocodes SET discount = FLOOR(discount)');
        DB::statement('UPDATE promocodes SET min_purchase = FLOOR(min_purchase)');

        Schema::table('promocodes', function (Blueprint $table) {
            $table->integer('discount')->change();
            $table->integer('min_purchase')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->change();
            $table->decimal('min_purchase', 10, 2)->default(0)->change();
        });
    }
};
