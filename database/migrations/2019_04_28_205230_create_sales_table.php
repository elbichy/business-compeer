<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('business_id');
            $table->bigInteger('branch_id')->unsigned();
            $table->string('type');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('location');
            $table->string('productOrService');
            $table->integer('units');
            $table->integer('amount');
            $table->integer('balance');
            $table->integer('change');
            $table->timestamps();
            $table->foreign('branch_id')
                    ->references('id')->on('branches')
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
        Schema::dropIfExists('sales');
    }
}
