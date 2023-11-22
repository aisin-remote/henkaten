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
            $table->string('employee_before_id', 191)->nullable()->after('troubleshoot');
            $table->string('employee_after_id', 191)->nullable()->after('employee_before_id');
            $table->foreign('employee_before_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('employee_after_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
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
