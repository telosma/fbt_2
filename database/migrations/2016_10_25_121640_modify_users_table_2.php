<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable2 extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('password')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        //
    }
}
