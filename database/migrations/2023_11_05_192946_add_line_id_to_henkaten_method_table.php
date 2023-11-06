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
        Schema::table('henkaten_method', function (Blueprint $table) {
            $table->string('shift_id', 191)->nullable('false')->after('id');
            $table->string('line_id', 191)->nullable('false')->after('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('henktaten_method', function (Blueprint $table) {
            //
        });
    }
};
