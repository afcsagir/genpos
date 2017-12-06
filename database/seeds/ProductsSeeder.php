<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Article::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Article::create([
                
                'name' => $faker->name,
                'type' => $faker->company,
                'category' => $faker->creditCardType,
                'sub' => $faker->userName
                'price' => $faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'),
                'quantity' => $faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt')

                					
            ]);
        }
    }
}
