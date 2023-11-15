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
        Schema::create('henkaten_method', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('pic')->nullable();
            $table->text('henkaten_description')->nullable();
            $table->enum('type', ['plan','unplan'])->nullable();
            $table->timestamp('date')->useCurrent(false);
            $table->string('troubleshoot')->nullable();
            $table->string('approval')->nullable();
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
        Schema::dropIfExists('henkaten_method');
    }
};
