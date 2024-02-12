<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BlogPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $this->call([
//            BlogPageSeeder::class,
//            PostSeeder::class
//        ]);
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Artem Developer',
             'email' => 'artem.yablochnyi@gmail.com',
             'password' => Hash::make('qwerty1903'),
             'city' => 'Киев',
             'is_admin' => true
         ]);
        \App\Models\User::factory()->create([
            'name' => 'Artem Admin',
            'email' => 'wlass3377@gmail.com',
            'password' => Hash::make('t2FiVZYQ9t'),
            'city' => 'Киев',
            'is_admin' => true
        ]);
    }
}
