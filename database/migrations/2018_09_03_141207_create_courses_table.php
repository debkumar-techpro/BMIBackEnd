<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('courses', function (Blueprint $table) {
            //page1
            $table->increments('id');
            $table->string('cover_img')->nullable();
            $table->string('name')->nullable();
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_till')->nullable();

            $table->unsignedInteger('programme_id');
            $table->foreign('programme_id')->references('id')->on('programmes');

            $table->unsignedInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');

            $table->unsignedInteger('title_or_subject_id');
            $table->foreign('title_or_subject_id')->references('id')->on('title_or_subjects');

            $table->unsignedInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages');

            $table->string('course_keywords')->nullable();

            $table->unsignedInteger('venue_id');
            $table->foreign('venue_id')->references('id')->on('venues');
            //page2
            $table->text('why_this_cource');
            $table->string('why_this_cource_attach_file')->nullable();
            $table->string('why_this_cource_attach_video')->nullable();
            $table->text('general_information');
            $table->string('general_information_attach_file')->nullable();
            $table->string('general_information_attach_video')->nullable();
            $table->text('whats_new');
            $table->string('whats_new_attach_file')->nullable();
            $table->string('whats_new_attach_video')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
