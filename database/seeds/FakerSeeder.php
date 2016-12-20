<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 10)->create();
        factory(App\Category::class, 20)->create();
        factory(App\Category::class, 30)->create();
    }
}
