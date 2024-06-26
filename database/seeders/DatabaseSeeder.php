<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\MaintenanceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MaintenanceSeeder::class,
            OeeSeeder::class,

        ]);
    }
}
