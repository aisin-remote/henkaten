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
        Schema::table('henkaten_material', function (Blueprint $table) {
            $table->enum('status', ['running', 'henkaten', 'stop', 'off'])->nullable('false')->after('pic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('henkaten_masterial', function (Blueprint $table) {
            //
        });
    }
};
