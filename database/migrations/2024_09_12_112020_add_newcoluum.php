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
        Schema::table('chk_truck_part1s', function (Blueprint $table) {
            $table->string('driver_prefix')->after('form_id');
            $table->string('driver_name')->after('driver_prefix');
            $table->string('driver_lastname')->after('driver_name');;
            $table->string('driver_phone')->after('driver_lastname');
            $table->string('driver_id')->after('driver_phone');
            $table->string('insure_name')->after('driver_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chk_truck_part1s', function (Blueprint $table) {
            $table->dropColumn('driver_prefix');
            $table->dropColumn('driver_name');  
            $table->dropColumn('driver_lastname');
            $table->dropColumn('driver_phone');
            $table->dropColumn('driver_id');
            $table->dropColumn('insure_name');
        });
    }
};
