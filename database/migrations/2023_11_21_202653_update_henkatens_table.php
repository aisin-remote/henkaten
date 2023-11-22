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
        Schema::table('henkatens', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->enum('status', ['running','henkaten', 'stop'])->after('4M');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('henkatens', function (Blueprint $table) {
            //
        });
    }
};
