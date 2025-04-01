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
        Schema::table('chk_truck_part2s', function (Blueprint $table) {
            $table->date('renew_chk_date')->after('chk_result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chk_truck_part2s', function (Blueprint $table) {
            $table->dropColumn('renew_chk_date');
        });
    }
};
