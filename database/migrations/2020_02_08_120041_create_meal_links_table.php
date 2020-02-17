<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('meal_id')->nullable();
            $table->string('link',900)->nullable();
            $table->string('meal_link',900)->nullable();
            $table->string('token',900)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('meal_links');
    }
}
