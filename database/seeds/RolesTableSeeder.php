<?php

use App\Profile;
use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        // Create Admin role
        $admin = new Role();
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();

        // Create Editor role
        $editor = new Role();
        $editor->name = "editor";
        $editor->display_name = "Editor";
        $editor->save();

        // Create Author role
        $author = new Role();
        $author->name = "author";
        $author->display_name = "Author";
        $author->save();

        // Create user role
        $user = new Role();
        $user->name = "user";
        $user->display_name = "User";
        $user->save();

        // Attach the roles
        // first user as admin
        $user1 = User::first();
        $user1->detachRole($admin);
        $user1->attachRole($admin);

        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->profile()->save(new Profile);
            $user->detachRole('user');
            $user->attachRole('user');
        });

        if (env('APP_ENV') == 'local') {
            // second user as editor
            $user2 = User::find(2);
            $user2->detachRole($editor);
            $user2->attachRole($editor);

            // third user as author
            $user3 = User::find(3);
            $user3->detachRole($author);
            $user3->attachRole($author);
        }
    }
}
