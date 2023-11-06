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
        Schema::table('lines', function (Blueprint $table) {
            $table->enum('status_man', ['running', 'henkaten', 'stop', 'off'])->default('running')->after('name');
            $table->enum('status_method', ['running', 'henkaten', 'stop', 'off'])->default('running')->after('status_man');
            $table->enum('status_machine', ['running', 'henkaten', 'stop', 'off'])->default('running')->after('status_method');
            $table->enum('status_material', ['running', 'henkaten', 'stop', 'off'])->default('running')->after('status_machine');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lines', function (Blueprint $table) {
            //
        });
    }
};
