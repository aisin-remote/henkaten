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
        Schema::table('pic_active', function (Blueprint $table) {
            $table->string('shift_id', 191)->nullable('false')->after('employee_id');
            $table->date('expired_at')->nullable()->after('active_from');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pic_active', function (Blueprint $table) {
            //
        });
    }
};
