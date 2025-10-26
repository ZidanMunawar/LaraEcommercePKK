<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Shipping Methods (Simplified)
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('cost', 10, 2);
            $table->string('estimated_days', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Transaksi
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_customers');

            // Shipping Info
            $table->unsignedBigInteger('id_shipping_method')->nullable();
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->string('resi_number', 100)->nullable();

            // Pricing
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);

            // Payment Info
            $table->string('metode_pembayaran', 50);
            $table->string('snap_token', 255)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('payment_status', 50)->default('pending');
            $table->timestamp('paid_at')->nullable();

            // Order Info
            $table->string('status', 30);
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamps();

            $table->foreign('id_customers')->references('id_customers')->on('customers')->onDelete('restrict');
            $table->foreign('id_shipping_method')->references('id')->on('shipping_methods')->onDelete('set null');
            $table->foreign('approved_by')->references('id_admin')->on('admins')->onDelete('set null');

            // Indexes
            $table->index('id_customers');
            $table->index('status');
            $table->index('payment_status');
            $table->index('transaction_id');
        });

        // Detail Transaksi
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_size')->nullable();
            $table->unsignedBigInteger('id_color')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('qty');
            $table->decimal('diskon', 12, 2)->default(0);

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('restrict');
            $table->foreign('id_size')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('id_color')->references('id')->on('colors')->onDelete('set null');
        });

        // Payment Logs (Optional)
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->string('transaction_id', 100)->nullable();
            $table->string('order_id', 100)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->decimal('gross_amount', 12, 2)->nullable();
            $table->string('transaction_status', 50)->nullable();
            $table->string('fraud_status', 50)->nullable();
            $table->string('status_code', 10)->nullable();
            $table->text('response_midtrans')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_logs');
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('shipping_methods');
    }
};
