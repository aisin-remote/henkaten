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
        Schema::create('troubleshoots', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('henkaten_id', 191)->nullable('false');
            $table->string('troubleshoot')->nullable();
            $table->enum('result_check', ['ok', 'ng']);
            $table->enum('inspection_report', ['need', 'no need']);
            $table->string('part')->nullable();
            $table->enum('before_treatment', ['ok', 'ng']);
            $table->enum('after_treatment', ['ok', 'ng']);
            $table->string('done_by', 191)->nullable('false');
            $table->foreign('henkaten_id')->references('id')->on('henkatens')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('done_by')->references('id')->on('employees')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('troubleshoots');
    }
};
