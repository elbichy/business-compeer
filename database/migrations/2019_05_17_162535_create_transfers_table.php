<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sale_id')->unsigned();
            $table->string('refNumber')->nullable();
            $table->string('recievers_firstname')->nullable();
            $table->string('recievers_lastname')->nullable();
            $table->string('bankName')->nullable();
            $table->string('accountType')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('recievers_phone')->nullable();
            $table->integer('amount')->nullable();
            $table->string('amountInWords')->nullable();
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('sale_id')
                    ->references('id')->on('sales')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
