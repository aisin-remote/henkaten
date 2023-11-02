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
        Schema::create('henkaten_material', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('pic')->nullable();
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
        Schema::dropIfExists('henkaten_material');
    }
};
