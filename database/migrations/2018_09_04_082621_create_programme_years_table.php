<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammeYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programme_years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->nullable();
            $table->enum('type', ['0', '1'])
                ->default('0')
                ->comment = '0: unset, 1:set';
            $table->unsignedInteger('programme_id');
            $table->foreign('programme_id')->references('id')->on('programmes');
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
        Schema::dropIfExists('programme_years');
    }
}
