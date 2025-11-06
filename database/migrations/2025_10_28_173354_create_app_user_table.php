<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->id(); // Primary key
            // Original unique identifiers
            $table->string('pvid', 10)->nullable()->index();
            $table->string('user', 50)->unique(); // username
            $table->string('title', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password'); // Hashed password

            // Role / Permissions
            $table->unsignedBigInteger('role_id')->nullable()->comment('FK to role_list');
            $table->enum('panel', ['A', 'S', 'U'])->default('A')->comment('A=Admin, S=Staff, U=User');

            // Status
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            // Contact info
            $table->string('contact_number', 25)->nullable();
            $table->string('img_url', 255)->nullable();
            $table->string('tzone', 100)->nullable()->comment('Timezone');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('address', 255)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 3)->nullable()->comment('ISO country code');
            $table->date('dob')->nullable();

            // Settings
            $table->boolean('is_enable_chat')->default(true);

            // Metadata
            $table->timestamp('add_date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key example (optional)
            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_user');
    }
};
