<?php

use App\Profile;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users and profiles tables
        User::truncate();
        Profile::truncate();

        if (env('APP_ENV') == 'local') {
            User::create([
                'name' => "Patryk Pilek",
                'slug' => 'patryk-pilek',
                'email' => "patryk.pilek@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ])->profile()->save(new Profile);

            User::create([
                'name' => "Lukasz Pilek",
                'slug' => 'lukasz-pilek',
                'email' => "lukasz.pilek@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ])->profile()->save(new Profile);

            User::create([
                'name' => "Krysytna Pilek",
                'slug' => 'krysytna-pilek',
                'email' => "krysytna.pilek@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ])->profile()->save(new Profile);
        } else {
            User::create([
                'name' => "Administrator",
                'slug' => 'admin',
                'email' => "admin@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10)
            ])->profile()->save(new Profile);
        }
    }
}
