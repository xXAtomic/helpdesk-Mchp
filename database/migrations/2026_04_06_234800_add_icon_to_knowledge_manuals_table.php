<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('knowledge_manuals', function (Blueprint $table) {
            if (!Schema::hasColumn('knowledge_manuals', 'icon')) {
                $table->string('icon')->nullable()->default('📖')->after('title');
            }
        });
    }

    public function down()
    {
        Schema::table('knowledge_manuals', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
