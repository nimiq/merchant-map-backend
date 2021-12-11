<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label');
            $table->longText('description');

            /** Source information */
            $table->string('object_id');
            $table->string('source_id');

            /** Contact information */
            $table->string('website');
            $table->string('email');
            $table->string('phone');
            $table->string('street');
            $table->string('number');
            $table->string('zip');
            $table->string('city');
            $table->string('country');

            $table->boolean('digital_goods');

            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
