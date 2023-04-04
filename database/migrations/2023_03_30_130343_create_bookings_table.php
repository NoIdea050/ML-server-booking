<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('start_date_and_time', $precision = 0);
            $table->dateTime('end_date_and_time', $precision = 0);
            $table->bigInteger('storage_id')->unsigned()->index()->nullable();
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->decimal('credit', $precision = 8, $scale = 2)->nullable();
            $table->decimal('credit_cost', $precision = 8, $scale = 2)->default(0);
            $table->integer('status')->default(0); //0->pending; 1->confirm; 2->reject; 3->cancel_by_user;
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
        Schema::dropIfExists('bookings');
    }
}