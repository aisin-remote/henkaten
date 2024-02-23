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
            $table->string('pic_before_id', 191)->nullable()->after('employee_after_id');
            $table->string('pic_after_id', 191)->nullable()->after('pic_before_id');
            $table->foreign('pic_before_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('pic_after_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
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
