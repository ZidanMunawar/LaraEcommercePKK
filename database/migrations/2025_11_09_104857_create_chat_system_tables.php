<?php
// database/migrations/2025_10_27_000000_create_chat_system_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Tabel chat_rooms
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id('id_room');
            $table->unsignedBigInteger('id_customers');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->enum('status', ['active', 'resolved', 'pending'])->default('active');
            $table->string('subject')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->foreign('id_customers')->references('id_customers')->on('customers')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('set null');

            $table->index(['status', 'last_message_at']);
        });

        // Tabel chat_messages
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id('id_messages');
            $table->unsignedBigInteger('id_room');
            $table->enum('sender_type', ['customer', 'admin']);
            $table->unsignedBigInteger('sender_id');
            $table->enum('message_type', ['text', 'image', 'file'])->default('text');
            $table->text('isi_pesan')->nullable();
            $table->string('image_url')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('id_room')->references('id_room')->on('chat_rooms')->onDelete('cascade');

            $table->index(['id_room', 'created_at']);
            $table->index(['sender_type', 'sender_id']);
            $table->index('is_read');
        });

        // Tabel admin_chat_assignments untuk melacak admin yang ditugaskan
        Schema::create('admin_chat_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_room');
            $table->unsignedBigInteger('id_admin');
            $table->timestamp('assigned_at');
            $table->timestamp('unassigned_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('id_room')->references('id_room')->on('chat_rooms')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('cascade');

            $table->index(['id_admin', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_chat_assignments');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_rooms');
    }
};
