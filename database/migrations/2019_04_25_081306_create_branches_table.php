<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_id')->unsigned();
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->date('commissionDate')->nullable();
            $table->string('openHour');
            $table->string('closeHour');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('business_id')
                    ->references('id')->on('businesses')
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
        Schema::dropIfExists('branches');
    }
}
