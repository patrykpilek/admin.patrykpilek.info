<?php

use App\Category;
use App\Post;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the posts table
        Post::truncate();

        // generate dummy posts data
        $posts = [];
        $faker = Factory::create();
        $date = Carbon::now()->modify('-1 year');

        for ($i = 1; $i <= 300; $i++) {

            $date->addDays(10);
            $publishedDate = clone($date);
            $createdDate   = clone($date);
            $title = $faker->sentence(rand(8, 12));
            $paragraphs = $faker->paragraphs(rand(10, 15), true);

            $posts[] = [
                'author_id'    => rand(2, 3),
                'category_id'  => rand(1, Category::all()->count()),
                'title'        => Str::title($title),
                'slug'         => Str::slug($title, '-'),
                'excerpt'      => Str::limit($paragraphs, 300, '(...)'),
                'body'         => $paragraphs,
                'image'        => 'default_post_image.jpg',
                'created_at'   => $createdDate,
                'updated_at'   => $createdDate,
                'published_at' => $i < 30 ? $publishedDate : ( rand(0, 1) == 0 ? NULL : $publishedDate->addDays(4) ),
                'view_count' => rand(1, 10) * 10,
                'meta_description' => "Meta for $title"
            ];
        }

        Post::insert($posts);
    }
}
