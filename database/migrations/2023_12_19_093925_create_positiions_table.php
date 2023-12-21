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
        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('line_id', 191)->nullable('false');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('pos')->nullable();
            $table->integer('top')->nullable();
            $table->integer('left')->nullable();
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
        Schema::dropIfExists('positions');
    }
};
