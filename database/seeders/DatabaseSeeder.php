<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


use App\Models\User;
use App\Models\Company;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create(['role' => 'admin', 'email' => 'test@test.com', 'company'=> null]);
        User::factory(20)->create(['role' => 'company']);

        Company::factory(20)->create();

        $faker = Faker::create();

        for ($i = 0; $i < 60; $i++){

            $user = User::create([
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'company' => rand (1,20),
                'role' => 'employee',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

            Employee::create([
                'company' => $user->company, 
                'profile' => $user->id
            ]);


        }
    }
}
