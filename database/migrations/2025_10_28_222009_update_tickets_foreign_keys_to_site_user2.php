<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Drop old FKs
            $table->dropForeign(['ticket_user']);
            $table->dropForeign(['assigned_to']);

            // Re-add referencing site_user
            $table->foreign('ticket_user')
                ->references('id')
                ->on('site_user')
                ->cascadeOnDelete();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('app_user')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['ticket_user']);
            $table->dropForeign(['assigned_to']);

            // revert back to users table
            $table->foreign('ticket_user')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
