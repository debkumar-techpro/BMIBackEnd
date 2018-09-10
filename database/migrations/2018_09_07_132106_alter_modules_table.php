<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {

            $table->unsignedInteger('programme_id')->after('id');
            $table->foreign('programme_id')->references('id')->on('programmes');

            $table->unsignedInteger('class_id')->after('programme_id');
            $table->foreign('class_id')->references('id')->on('classes');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
