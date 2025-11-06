<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('global_app_user_messages', function (Blueprint $table) {
            $table->id();

            // Sender and receiver
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');

            // Optional ticket link (for context)
            $table->unsignedBigInteger('ticket_id')->nullable();

            // Message content
            $table->text('message');

            // Message metadata
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->enum('status', ['sent', 'delivered', 'read', 'deleted'])
                  ->default('sent');

            $table->timestamps();

            // Foreign keys
            $table->foreign('sender_id')->references('id')->on('app_user')->cascadeOnDelete();
            $table->foreign('receiver_id')->references('id')->on('app_user')->cascadeOnDelete();
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('global_messages');
    }
};
