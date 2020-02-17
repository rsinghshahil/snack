<?php

use Illuminate\Database\Seeder;
use App\BreadType;
use App\BreadSize;
use App\Flavour;
use App\Vegetable;
use App\Sauce;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\BreadType',5)->create();
        factory('App\BreadSize',5)->create();
        factory('App\Flavour',5)->create();
        factory('App\Vegetable',5)->create();
        factory('App\Sauce',5)->create();
    }
}
