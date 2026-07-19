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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            // Ticket
            $table->foreignId('ticket_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // User who performed the action
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Action performed
            $table->string('action');

            // More details
            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};