<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startAt = Carbon::parse(sprintf('%s:00', $this->faker->numberBetween(8,16)));

        return [
            'visit_date' => now()->addDays($this->faker->numberBetween(0, 10)),
            'start_at' => $startAt->format('H:i'),
            'end_at' => $startAt->addMinutes($this->faker->numberBetween(30, 180))->format('H:i'),
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(100, 500),
        ];
    }
}
