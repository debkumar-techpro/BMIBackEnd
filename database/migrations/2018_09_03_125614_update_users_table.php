<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('type', ['0', '1', '2', '3', '4', '5'])
                ->default('0')
                ->after('id')
                ->comment = '0: NA, 1:Super Admin, 2:Admin, 3: Alumni, 4: Teacher, 5: Student';
            $table->string('phone')
                ->nullable()
                ->after('email');
            $table->date('date_of_birth')
                ->nullable()
                ->after('remember_token');
            $table->enum('gender', ['NA', 'M', 'F', 'O'])
                ->default('NA')
                ->after('date_of_birth');
            $table->text('address')
                ->nullable()
                ->after('gender');
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
