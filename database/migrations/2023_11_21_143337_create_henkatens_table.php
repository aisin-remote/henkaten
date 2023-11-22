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
        Schema::create('henkatens', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->enum('4M', ['man','method','machine', 'material'])->nullable();
            $table->string('shift_id', 191)->nullable('false');
            $table->string('line_id', 191)->nullable('false');
            $table->enum('category', ['Safety Issue','Productivity Issue','Cost Issue', 'Other'])->nullable();
            $table->string('henkaten_management_id', 191)->nullable('false');
            $table->string('abnormality')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('date')->useCurrent(false);
            $table->enum('is_done', ['0', '1'])->nullable();
            $table->string('approval')->nullable();
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('henkaten_management_id')->references('id')->on('henkaten_managements')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('henkatens');
    }
};
