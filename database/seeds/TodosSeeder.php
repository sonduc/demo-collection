<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Todo::class, 1000)->create();

    }
}
