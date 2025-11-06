<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('canned_messages', function (Blueprint $table) {
    $table->id();

    // Linked to app user who created it (instead of admin)
    $table->unsignedBigInteger('created_by')->nullable();

    // Optional relationships to categories/subcategories/services
    $table->unsignedBigInteger('category_id')->nullable();
    $table->unsignedBigInteger('subcategory_id')->nullable();
    $table->unsignedBigInteger('service_id')->nullable();

    // Core message info
    $table->string('title');
    $table->string('subject')->nullable();
    $table->text('body');
    $table->enum('type', ['text', 'html', 'markdown'])->default('text');
    $table->boolean('is_global')->default(false);
    $table->enum('status', ['active', 'inactive'])->default('active');

    $table->timestamps();

    // Foreign keys
    $table->foreign('created_by')->references('id')->on('app_user')->nullOnDelete();
    $table->foreign('category_id')->references('id')->on('ticket_main_categories')->nullOnDelete();
    $table->foreign('subcategory_id')->references('id')->on('ticket_subcategories')->nullOnDelete();
    $table->foreign('service_id')->references('id')->on('ticket_services')->nullOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canned_messages');
    }
};
