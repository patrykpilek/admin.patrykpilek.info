<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local') {
            $categories = [
                [
                    'title' => 'Uncategorized',
                    'slug' => 'uncategorized',
                    'meta_description' => "Meta for uncategorized"
                ],
                [
                    'title' => 'Tips and Tricks',
                    'slug' => 'tips-and-tricks',
                    'meta_description' => "Meta for tips-and-tricks"
                ],
                [
                    'title' => 'Build Apps',
                    'slug' => 'build-apps',
                    'meta_description' => "Meta for build-apps"
                ],
                [
                    'title' => 'News',
                    'slug' => 'news',
                    'meta_description' => "Meta for news"
                ],
                [
                    'title' => 'Freebies',
                    'slug' => 'freebies',
                    'meta_description' => "Meta for freebies"
                ],
            ];
        } else {
            $categories = [
                'title' => 'Uncategorized',
                'slug' => 'uncategorized',
                'meta_description' => "Meta for uncategorized"
            ];
        }

        Category::truncate();
        Category::insert($categories);

    }
}
