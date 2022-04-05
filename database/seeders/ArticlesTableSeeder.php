<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $faker = \Faker\Factory::create();

        // now let create a few articles in our database
        for ($i = 1; $i <= 20; $i++) {
            Post::create([
                'cover' => $faker->name,
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
            ]);
    }
}
}
