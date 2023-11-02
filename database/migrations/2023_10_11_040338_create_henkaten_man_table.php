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
        Schema::create('henkaten_man', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('employee_before_id', 191)->nullable('false');
            $table->string('employee_after_id', 191)->nullable('false');
            $table->string('shift_id', 191)->nullable('false');
            $table->string('line_id', 191)->nullable('false');
            $table->string('pic')->nullable();
            $table->foreign('employee_before_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('employee_after_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->text('henkaten_description')->nullable();
            $table->enum('type', ['plan','unplan']);
            $table->timestamp('date');
            $table->string('troubleshoot')->nullable();
            $table->string('approval');
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
        Schema::dropIfExists('henkaten_man');
    }
};
