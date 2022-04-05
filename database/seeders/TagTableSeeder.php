<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Tag::truncate();

        $faker = \Faker\Factory::create();

        // now let create a few articles in our database
        for ($i = 1; $i <= 20; $i++) {
           Tag::create([
                'name' => $faker->name,
                'url' => $faker->url,
                'post_id' => $i,
            ]);
    }
    }
}
