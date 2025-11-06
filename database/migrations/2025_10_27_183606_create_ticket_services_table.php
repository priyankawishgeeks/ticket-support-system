<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::create('ticket_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id'); // Dependable to subcategory
            $table->string('name'); // e.g., reshan.com
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign Key
            $table->foreign('subcategory_id')
                ->references('id')
                ->on('ticket_subcategories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_services');
    }
};
