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
        Schema::create('phrase_positions', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('phrase_id');
            $table->foreign('phrase_id')->references('id')->on('phrases');

            $table->string('position', 1024)->nullable();

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
        Schema::dropIfExists('phrase_positions');
    }
};
