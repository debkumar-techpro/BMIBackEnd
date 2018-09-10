<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrammeUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programme_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->enum('type', ['0', '1', '2'])
                ->default('0')
                ->comment = '0: NA, 1:Photo, 2:Youtube/Vmio';
                
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
        Schema::dropIfExists('programme_uploads');
    }
}
