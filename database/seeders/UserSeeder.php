<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        // insertar usuario admin primero
        DB::table('users')->insert([
            'id' => $faker->uuid,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'birthDate' => null,
            'createdAt' => now(),
            'updatedAt' => now(),
        ]);


        for ($i = 0; $i < 1000; $i++) {
            DB::table('users')->insert([
                'id' => $faker->uuid,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'birthDate' => $faker->dateTimeBetween('1980-01-01', '2010-12-31')->format('Y-m-d'),
                'createdAt' => now(),
                'updatedAt' => now(),
            ]);
        }
    }
}
