<?php

namespace Database\Seeders;

use App\Models\WorkingDay;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class WorkingDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for($i=0; $i < 400; $i++) {
            try {
                WorkingDay::factory()
                    ->create();
            } catch (QueryException) {
                continue;
            }
        }
    }
}
