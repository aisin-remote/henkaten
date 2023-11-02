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
        Schema::create('pivots', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('theme_id')->nullable();
            $table->string('custom_theme')->nullable();
            $table->string('first_pic_id')->nullable();
            $table->string('second_pic_id')->nullable();
            $table->date('active_date')->nullable();
            $table->foreign('first_pic_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('second_pic_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('theme_id')->references('id')->on('themes')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('pivots');
    }
};
