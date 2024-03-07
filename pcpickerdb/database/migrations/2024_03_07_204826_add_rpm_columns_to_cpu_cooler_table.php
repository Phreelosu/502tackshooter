<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRpmColumnsToCpuCoolerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpu_cooler', function (Blueprint $table) {
            $table->integer('Cooler_RPM_Min')->nullable();
            $table->integer('Cooler_RPM_Max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpu_cooler', function (Blueprint $table) {
            $table->dropColumn('Cooler_RPM_Min');
            $table->dropColumn('Cooler_RPM_Max');
        });
    }
}
