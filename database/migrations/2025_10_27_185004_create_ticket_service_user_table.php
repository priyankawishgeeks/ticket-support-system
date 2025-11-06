<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('ticket_service_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('service_id')
                ->references('id')
                ->on('ticket_services')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Prevent duplicate assignments
            $table->unique(['service_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_service_user');
    }
};
