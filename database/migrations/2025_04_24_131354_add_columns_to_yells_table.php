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
        Schema::table('yells', function (Blueprint $table) {
            $table->string('item_no_1')->after('id');
            $table->string('item_no_2')->after('item_no_1');
            $table->string('item_no_3')->after('item_no_2');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yells', function (Blueprint $table) {
            //
        });
    }
};
