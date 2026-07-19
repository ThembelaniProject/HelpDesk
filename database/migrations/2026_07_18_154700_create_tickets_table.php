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
    Schema::create('tickets', function (Blueprint $table) {

        $table->id();

        $table->string('title');

        $table->text('description');

        $table->enum('priority', [
            'Low',
            'Medium',
            'High',
            'Critical'
        ]);

        $table->enum('status', [
            'Open',
            'Assigned',
            'In Progress',
            'Resolved',
            'Closed'
        ])->default('Open');

        $table->foreignId('category_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('technician_id')
              ->nullable()
              ->references('id')
              ->on('users')
              ->nullOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
