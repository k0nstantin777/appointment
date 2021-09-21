<?php

namespace Database\Seeders;

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
        $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(VisitsTableSeeder::class);
        $this->call(WorkingDaysTableSeeder::class);
    }
}
