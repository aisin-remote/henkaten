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
        Schema::table('employee_active', function (Blueprint $table) {
            $table->string('pos_id', 191)->nullable()->after('pos');
            $table->foreign('pos_id')->references('id')->on('positions')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_active', function (Blueprint $table) {
            //
        });
    }
};
