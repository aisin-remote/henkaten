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
        Schema::create('minimum_skills', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('line_id')->nullable('false');
            $table->enum('pos', [1,2, 'lastman']);
            $table->string('skill_id')->nullable('false');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('minimum_skills');
    }
};
