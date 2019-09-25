<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roadworks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('eid');
            $table->string('teEventType');
            $table->longText('cause');
            $table->string('long');
            $table->string('lat');
            $table->string('roadName');
            $table->string('overallStartDate');
            $table->string('overallEndDate');
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
        Schema::dropIfExists('roadworks');
    }
}
