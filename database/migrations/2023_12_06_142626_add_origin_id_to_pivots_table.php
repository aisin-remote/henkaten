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
        Schema::table('pivots', function (Blueprint $table) {
            $table->string('origin_id', 191)->nullable('false')->after('theme_id');
            $table->foreign('origin_id')->references('id')->on('origins')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivtos', function (Blueprint $table) {
            //
        });
    }
};
