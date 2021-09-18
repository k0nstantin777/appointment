<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory()
            ->count(10)
            ->create()
            ->each(function (Employee $employee){
                $serviceIds = Service::inRandomOrder()->take(2)->pluck('id')->toArray();
                $employee->services()->attach($serviceIds);
            });
    }
}
