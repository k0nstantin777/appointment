<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Visit;
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
        return [
            'date' => $this->faker->dateTimeInInterval('-5days', '+15 days'),
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(100, 500),
        ];
    }
}
