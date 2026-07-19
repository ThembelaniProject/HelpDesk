<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            if (!Schema::hasColumn('tickets', 'due_date')) {
                $table->timestamp('due_date')->nullable()->after('technician_id');
            }

            // Remove this if resolved_at already exists
            // $table->timestamp('resolved_at')->nullable()->after('due_date');

        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {

            if (Schema::hasColumn('tickets', 'due_date')) {
                $table->dropColumn('due_date');
            }

        });
    }
};