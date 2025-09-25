<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        $users = User::factory(10)->create();

        $companies = Company::factory(5)->create();

        Task::factory(30)->create();
    }
}
