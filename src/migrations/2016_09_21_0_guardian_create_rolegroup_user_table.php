<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GuardianCreateRolegroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rolegroup_user'))
        
            Schema::create ('rolegroup_user', function (Blueprint $table)
            {
                $table->increments ('id');
                $table->integer ('rolegroup_id');
                $table->integer ('user_id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists ('rolegroup_user');
    }
}
