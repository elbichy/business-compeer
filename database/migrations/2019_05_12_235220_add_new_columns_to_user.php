<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identityType')->nullable()->after('currentAddress');
            $table->string('identityNumber')->nullable()->after('identityType');
            $table->string('idCard')->nullable()->after('image');
            $table->string('signature')->nullable()->after('idCard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('identityType');
            $table->dropColumn('identityNumber');
            $table->dropColumn('idCard');
            $table->dropColumn('signature');
        });
    }
}
