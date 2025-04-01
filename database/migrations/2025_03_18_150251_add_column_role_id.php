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
        Schema::table('form_chks', function (Blueprint $table) {
            $table->smallInteger('role_id')->after('form_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_chks', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
};
