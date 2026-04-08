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
        Schema::table('ticket_priorities', function (Blueprint $table) {
            $table->integer('sla_hours')->default(24);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('due_at')->nullable();
            $table->boolean('sla_breached')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_priorities', function (Blueprint $table) {
            $table->dropColumn('sla_hours');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['due_at', 'sla_breached']);
        });
    }
};
