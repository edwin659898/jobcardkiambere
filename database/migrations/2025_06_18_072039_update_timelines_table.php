<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timelines', function(Blueprint $table){

            $table->dateTime('sort_started_at')->nullable();
        });   
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timelines', function(Blueprint $table){

            $table->dropColumn('sort_started_at')->nullable();
        });   
    }
};
