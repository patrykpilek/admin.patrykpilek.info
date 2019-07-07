<?php

/** @var Factory $factory */
use App\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    $full_name = $first_name . ' ' . $last_name;

    return [
        'name' => ucfirst($full_name),
        'slug' => Str::slug($full_name, '-'),
        'email' => strtolower($first_name . '.' . $last_name) . '@' . $faker->freeEmailDomain,
        'email_verified_at' => rand(0, 1) == 1 ? now() : NULL,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10)
    ];
});
