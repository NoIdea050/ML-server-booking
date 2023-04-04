<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('credit', $precision = 8, $scale = 2)->nullable();
            $table->dateTime('requested_date_and_time', $precision = 0)->nullable(); //requested date and time
            $table->text('message')->nullable();
            $table->dateTime('date_and_time', $precision = 0)->nullable();
            $table->string('status')->nullable()->default(1);//1->accepted; 0->requested; 2->rejected
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
        Schema::dropIfExists('credit_histories');
    }
}
