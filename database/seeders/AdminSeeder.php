<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'profile_image' => null,
            'name' => 'Administrator',
            'address' => fake()->address,
            'phone' => fake()->phoneNumber,
            'age' => fake()->numberBetween(18, 99),
            'gender' => 'Male',
            'birthday' => fake()->date,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ])->assignRole('Admin', 'User')
            ->givePermissionTo('manage-all', 'customer',);

        User::factory()->create([
            'profile_image' => null,
            'name' => 'Test User',
            'address' => fake()->address,
            'phone' => fake()->phoneNumber,
            'age' => fake()->numberBetween(18, 99),
            'gender' => 'Male',
            'birthday' => fake()->date,
            'email' => 'testgmail@gmail.com',
            'password' => bcrypt('password')
        ])->assignRole('User')
            ->givePermissionTo('customer');
    }
}
