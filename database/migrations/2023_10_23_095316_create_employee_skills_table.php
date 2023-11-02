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
        Schema::create('employee_skills', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('employee_id', 191)->nullable('false');
            $table->string('skill_id', 191)->nullable();
            $table->date('active_until')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('employee_skills');
    }
};
