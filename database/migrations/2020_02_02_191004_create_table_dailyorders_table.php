<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDailyordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('meal_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();

            $table->string('bread_type')->nullable();
            $table->string('bread_size')->nullable();
            $table->string('flavour')->nullable();
            $table->string('vegetable')->nullable();
            $table->string('sauce')->nullable();
            $table->boolean('non_baked')->default(0)->comment = "0 = non-baked; 1 = Baked";

            $table->string('total_cost')->nullable();
            $table->integer('status')->default(0)->comment = "100 = taken; 200 = ready; 300 = delivered; 400 = OK";
            $table->integer('rating')->default(0);
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
        Schema::dropIfExists('dailyorders');
    }
}
