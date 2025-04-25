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
        Schema::table('troubleshoots', function (Blueprint $table) {
            $table->string('pic_safety')->after('result_check')->nullable();
            $table->string('pic_quality')->after('after_treatment')->nullable();
            $table->string('done_by')->after('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('troubleshoots', function (Blueprint $table) {
            //
        });
    }
};
