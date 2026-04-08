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
        Schema::table('assets', function (Blueprint $table) {
            $table->string('entity')->nullable()->after('user_id'); // IASD or FESDG
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('entity')->nullable()->after('role_id'); // IASD or FESDG
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('entity');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('entity');
        });
    }
};
