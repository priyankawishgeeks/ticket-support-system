<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_attachments', function (Blueprint $table) {
            // Drop old foreign key to users
            $table->dropForeign(['uploaded_by']);

            // Re-add referencing app_user
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('app_user')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ticket_attachments', function (Blueprint $table) {
            // Drop the updated foreign key to app_user
            $table->dropForeign(['uploaded_by']);

            // Revert back to users table
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
