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
        Schema::table('ticket_attachments', function (Blueprint $table) {
            if (!Schema::hasColumn('ticket_attachments', 'ticket_response_id')) {
                $table->foreignId('ticket_response_id')
                    ->after('ticket_id')
                    ->nullable()
                    ->constrained('ticket_responses')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_attachments', function (Blueprint $table) {
            $table->dropForeign(['ticket_response_id']);
            $table->dropColumn('ticket_response_id');
        });
    }
};
