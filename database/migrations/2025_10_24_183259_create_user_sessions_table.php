<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('login_at')->useCurrent();
            $table->timestamp('logout_at')->nullable()->default(null);
            $table->foreignId('impersonated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps(); 
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
