<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notes', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('ticket_id')->nullable();  // Note belongs to a ticket
            $table->unsignedBigInteger('client_id')->nullable();  // Note on client (site_user)
            $table->unsignedBigInteger('created_by');             // Admin who created this note

            // Core content
            $table->string('title')->nullable();                  // Optional short title for the note
            $table->text('body');                                 // Actual note content (rich text or plain)
            
            // Note type
            $table->enum('note_type', ['ticket', 'client', 'general'])
                  ->default('ticket');                            // Default: note on ticket

            // Visibility and status
            $table->enum('visibility', ['private', 'team', 'public'])
                  ->default('private');                           // private = only creator, team = all admins, public = visible to client (if needed)
            $table->enum('status', ['active', 'archived', 'deleted'])
                  ->default('active');

            // Optional link to attachments (if later needed)
            $table->boolean('has_attachments')->default(false);

            // Contextual identifiers
            $table->string('ticket_track_id')->nullable();        // Human-readable ticket ID (TCK-XXXX)
            
            // Timestamps
            $table->timestamps();

            // Foreign keys
            $table->foreign('ticket_id')->references('id')->on('tickets')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('site_user')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('app_user')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notes');
    }
};
