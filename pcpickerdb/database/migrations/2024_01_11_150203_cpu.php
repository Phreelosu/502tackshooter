<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPU', function (Blueprint $table) {
            $table->id();
            $table->string('CPU_name', 255);
            $table->decimal('CPU_price')->nullable();
            $table->integer('CPU_core_count');
            $table->float('CPU_core_clock')->nullable();
            $table->float('CPU_boost_clock')->nullable();
            $table->string('CPU_graphics', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPU');
    }
};
