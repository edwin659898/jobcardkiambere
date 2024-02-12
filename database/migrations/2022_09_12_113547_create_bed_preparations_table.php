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
        Schema::create('bed_preparations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_activity_id');
            $table->foreignId('job_card_id')->constrained();
            $table->string('name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('uom')->nullable();
            $table->string('extra_information')->nullable();
            $table->unsignedBigInteger('tree_id');
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
        Schema::dropIfExists('bed_preparations');
    }
};
