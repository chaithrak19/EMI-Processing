<?php

use Illuminate\Database\Seeder;
use Database\Seeders\LoanDetailsSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LoanDetailsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
