<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Wishlist
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id('id_wishlist');
            $table->unsignedBigInteger('id_customers');
            $table->unsignedBigInteger('id_produk');
            $table->timestamps();

            $table->foreign('id_customers')->references('id_customers')->on('customers')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->unique(['id_customers', 'id_produk'], 'unique_wishlist');
        });

        // Keranjang
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_cart');
            $table->unsignedBigInteger('id_customers');
            $table->timestamps();

            $table->foreign('id_customers')->references('id_customers')->on('customers')->onDelete('cascade');
        });

        // Item Keranjang
        Schema::create('item_keranjang', function (Blueprint $table) {
            $table->id('id_cart_item');
            $table->unsignedBigInteger('id_cart');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_size')->nullable();
            $table->unsignedBigInteger('id_color')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('harga', 12, 2);

            $table->foreign('id_cart')->references('id_cart')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_size')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('id_color')->references('id')->on('colors')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_keranjang');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('wishlist');
    }
};
