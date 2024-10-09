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
            $table->enum('type',['planned','unplanned'])->after('id')->nullable();
            $table->date('start_date')->after('photo')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
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
