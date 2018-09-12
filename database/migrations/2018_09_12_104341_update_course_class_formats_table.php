<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCourseClassFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_class_formats', function (Blueprint $table) {
            $table->unsignedInteger('class_id')->after('course_id');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->text('days')->after('class_id');
            $table->json('schedule')->after('days');
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
