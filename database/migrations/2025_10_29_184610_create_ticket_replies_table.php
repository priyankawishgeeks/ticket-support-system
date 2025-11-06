<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();

            // Ticket reference
            $table->unsignedBigInteger('ticket_id');
            $table->string('ticket_track_id', 100)->nullable();

            // Who sent it
            $table->unsignedBigInteger('app_user_id')->nullable();
            $table->unsignedBigInteger('site_user_id')->nullable();

            // Reply details
            $table->text('reply_body');
            $table->json('attachments')->nullable(); // Store multiple attachments (URLs/paths)
            $table->enum('reply_type', ['public', 'internal'])->default('public'); // Internal = staff only

            // Optional parent ID for threaded conversation
            $table->unsignedBigInteger('parent_reply_id')->nullable();

            // Meta info
            $table->boolean('is_read')->default(false);
            $table->dateTime('read_at')->nullable();
            $table->enum('created_by_type', ['app_user', 'site_user']);
            $table->string('ip_address', 100)->nullable();
            $table->string('user_agent', 255)->nullable();

            // Soft deletes & timestamps
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('ticket_id')
                  ->references('id')
                  ->on('tickets')
                  ->onDelete('cascade');

            $table->foreign('app_user_id')
                  ->references('id')
                  ->on('app_user')
                  ->onDelete('set null');

            $table->foreign('site_user_id')
                  ->references('id')
                  ->on('site_user')
                  ->onDelete('set null');

            $table->foreign('parent_reply_id')
                  ->references('id')
                  ->on('ticket_replies')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
