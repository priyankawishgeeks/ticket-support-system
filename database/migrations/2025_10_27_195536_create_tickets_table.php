<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_track_id', 18)->unique();

            // Category → Subcategory → Service chain
            $table->unsignedBigInteger('cat_id')->nullable(); // main category
            $table->unsignedBigInteger('services_cat_id')->nullable(); // subcategory
            $table->unsignedBigInteger('services')->nullable(); // service
            $table->string('service_url')->nullable();

            // Core details
            $table->string('title', 150);
            $table->text('ticket_body');

            // User info
            $table->unsignedBigInteger('ticket_user'); // who opened the ticket
            $table->string('user_type', 2)->default('U'); 

            // Ticket status and priority
            $table->string('status', 20)->default('New'); 
            $table->string('priority', 20)->default('Medium'); 

            // Assigned user (staff/admin)
            $table->unsignedBigInteger('assigned_to')->nullable(); 
            $table->timestamp('assigned_date')->nullable();

            // Flags and metrics
            $table->boolean('is_public')->default(false);
            $table->boolean('is_open_using_email')->default(false);
            $table->boolean('is_paid_ticket')->default(false);
            $table->boolean('is_user_seen_last_reply')->default(true);

            $table->unsignedInteger('reply_counter')->default(0);
            $table->unsignedTinyInteger('ticket_rating')->nullable();

            // Reopen and reply tracking
            $table->timestamp('opened_time')->nullable();
            $table->timestamp('re_open_time')->nullable();
            $table->unsignedBigInteger('re_open_by')->nullable();
            $table->string('re_open_by_type', 2)->nullable();

            $table->unsignedBigInteger('last_replied_by')->nullable();
            $table->string('last_replied_by_type', 2)->nullable();
            $table->timestamp('last_reply_time')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('cat_id')->references('id')->on('ticket_main_categories')->nullOnDelete();
            $table->foreign('services_cat_id')->references('id')->on('ticket_subcategories')->nullOnDelete();
            $table->foreign('services')->references('id')->on('ticket_services')->nullOnDelete();
            $table->foreign('ticket_user')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('assigned_to')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
