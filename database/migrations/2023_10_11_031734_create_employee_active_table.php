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
        Schema::create('employee_active', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('employee_id', 191)->nullable('false');
            $table->string('shift_id', 191)->nullable('false');
            $table->string('line_id', 191)->nullable('false');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->enum('pos',['1','2'])->nullable('false');
            $table->date('active_from')->nullable('false');
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
        Schema::dropIfExists('employee_active');
    }
};
