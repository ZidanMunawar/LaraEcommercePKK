<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('payment_proof', 500)->nullable()->after('payment_type');
            $table->timestamp('payment_proof_uploaded_at')->nullable()->after('payment_proof');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['payment_proof', 'payment_proof_uploaded_at']);
        });
    }
};
