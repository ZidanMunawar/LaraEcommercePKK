<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id_feedback');
            $table->foreignId('id_customers')->constrained('customers', 'id_customers')->onDelete('cascade');
            $table->foreignId('id_transaksi')->nullable()->constrained('transaksi', 'id_transaksi')->onDelete('set null');
            $table->string('nama_pelanggan', 100);
            $table->text('pesan');
            $table->tinyInteger('rating')->checkBetween([1, 5]);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['is_approved', 'created_at']);
            $table->index('id_customers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
