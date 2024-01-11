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
        Schema::create('approvals', function (Blueprint $table) {
            $table->uuid('id', 191)->primary();
            $table->string('henkaten_id', 191)->nullable('false');
            $table->string('ldr')->nullable();
            $table->string('spv')->nullable();
            $table->string('mgr')->nullable();
            $table->enum('status', ['Leader', 'Supervisor', 'Manager']);
            $table->foreign('henkaten_id')->references('id')->on('henkatens')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('approvals');
    }
};
