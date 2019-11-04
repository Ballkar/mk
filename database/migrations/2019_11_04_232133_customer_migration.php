<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();

            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('road')->nullable();
            $table->string('house_number')->nullable();
            $table->string('flat_number')->nullable();

            $table->text('additional_info')->nullable();
            $table->timestamp('birth_date')->nullable();

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
        //
    }
}