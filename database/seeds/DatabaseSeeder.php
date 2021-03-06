<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('APP_ENV') == 'local') {
            $this->call(UsersTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(PostsTableSeeder::class);
            $this->call(TagsTableSeeder::class);
            $this->call(CommentsTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
        } else {
            $this->call(UsersTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
        }

        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
