<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnnouncementServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_services', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('announcement_id')->unsigned();
            $table->foreign('announcement_id')->references('id')->on('announcements');
            $table->bigInteger('service_group_id')->unsigned();
            $table->foreign('service_group_id')->references('id')->on('service_groups');
            $table->string('name')->nullable();
            $table->integer('price');
            $table->integer('time_hours');
            $table->integer('time_minutes');
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
