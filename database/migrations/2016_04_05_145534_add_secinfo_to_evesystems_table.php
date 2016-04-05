<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecinfoToEvesystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eve_systems', function (Blueprint $table) {
            $table->float('security_status');
            $table->string('security_class');
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
            $table->dropColumn('security_status');
            $table->dropColumn('security_class');
        });
    }
}
