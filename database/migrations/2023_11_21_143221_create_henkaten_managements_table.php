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
        Schema::create('henkaten_managements', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->enum('4M', ['man','method','machine', 'material'])->nullable();
            $table->string('henkaten_item')->nullable();
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
        Schema::dropIfExists('henkaten_managements');
    }
};
