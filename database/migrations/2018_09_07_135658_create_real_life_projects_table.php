<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealLifeProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_life_projects', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');

            $table->unsignedInteger('programme_id');
            $table->foreign('programme_id')->references('id')->on('programmes');

            $table->unsignedInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            
            $table->string('name')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_life_projects');
    }
}
