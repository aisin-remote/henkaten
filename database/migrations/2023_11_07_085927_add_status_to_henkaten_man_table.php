<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('henkaten_man', function (Blueprint $table) {
            $table->enum('status', ['running', 'henkaten', 'stop', 'off'])->nullable('false')->after('pic');
            $table->string('henkaten_problem')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('henkaten_man', function (Blueprint $table) {
            //
        });
    }
};
