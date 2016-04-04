<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNeighboursToEvesystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eve_systems', function (Blueprint $table) {
            $table->string('neighbours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eve_systems', function (Blueprint $table) {
            $table->dropColumn('neighbours');
        });
    }
}
