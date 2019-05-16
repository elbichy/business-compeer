<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('business_id')->unsigned()->default(0);
            $table->bigInteger('branch_id')->unsigned()->default(0);
            $table->integer('role')->default(0);
            $table->rememberToken();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('permanentAddress')->nullable();
            $table->string('currentAddress')->nullable();
            $table->string('identityType')->nullable();
            $table->string('identityNumber')->nullable();
            $table->string('image')->nullable();
            $table->string('idCard')->nullable();
            $table->string('signature')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
