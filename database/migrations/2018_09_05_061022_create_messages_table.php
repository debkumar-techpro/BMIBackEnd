<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');

            $table->unsignedInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('users');

            $table->string('title')->nullable();
            $table->text('body');

            
            $table->enum('read_status', ['0', '1'])
                ->default('0')
                ->comment = '0: Unread, 1: Read';

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
        Schema::dropIfExists('messages');
    }
}
