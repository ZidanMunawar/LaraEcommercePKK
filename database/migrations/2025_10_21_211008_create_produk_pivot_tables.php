<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Produk Audiences
        Schema::create('produk_audiences', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->foreignId('id_audience')->constrained('audiences', 'id')->onDelete('cascade');
            $table->primary(['id_produk', 'id_audience']);
        });

        // Produk Categories
        Schema::create('produk_categories', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->foreignId('id_category')->constrained('categories', 'id')->onDelete('cascade');
            $table->primary(['id_produk', 'id_category']);
        });

        // Produk Colors
        Schema::create('produk_colors', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->foreignId('id_color')->constrained('colors', 'id')->onDelete('cascade');
            $table->primary(['id_produk', 'id_color']);
        });

        // Produk Sizes
        Schema::create('produk_sizes', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->foreignId('id_size')->constrained('sizes', 'id')->onDelete('cascade');
            $table->primary(['id_produk', 'id_size']);
        });

        // Produk Tags
        Schema::create('produk_tags', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onDelete('cascade');
            $table->foreignId('id_tag')->constrained('tags', 'id')->onDelete('cascade');
            $table->primary(['id_produk', 'id_tag']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_tags');
        Schema::dropIfExists('produk_sizes');
        Schema::dropIfExists('produk_colors');
        Schema::dropIfExists('produk_categories');
        Schema::dropIfExists('produk_audiences');
    }
};
