<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTruckIdColumnNeighborhood extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neighborhoods', function (Blueprint $table) {
            $table->unsignedInteger('truck_id')->nullable();;
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neighborhoods', function (Blueprint $table) {
            $table->dropForeign(['truck_id']);
        });
    }
}
