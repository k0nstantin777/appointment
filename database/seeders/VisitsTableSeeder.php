<?php

namespace Database\Seeders;

use App\Models\Visit;
use App\Services\Entities\Visit\ValidateVisitService;
use Illuminate\Database\Seeder;

class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visits = Visit::factory()
            ->count(2000)
            ->make();

        foreach ($visits as $visit) {
            $validator = ValidateVisitService::getInstance()->getValidator([
                'visit_date' => $visit->visit_date,
                'visit_start_at' => $visit->start_at->format('H:i'),
                'visit_end_at' => $visit->end_at->format('H:i'),
                'employee_id' => $visit->employee_id,
                'service_id' => $visit->service_id,
                'client_id' => $visit->client_id,
                'price' => $visit->price,
                'status' => $visit->status,
            ]);

            if ($validator->fails()) {
                continue;
            }
            $visit->save();
        }


    }
}
