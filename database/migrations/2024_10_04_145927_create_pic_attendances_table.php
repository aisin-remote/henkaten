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
        Schema::create('pic_attendance', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('pic_active_id', 191)->nullable('false');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->foreign('pic_active_id')->references('id')->on('pic_active')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pic_attendance');
    }
};
