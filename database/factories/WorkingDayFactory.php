<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\WorkingDay;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingDayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkingDay::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => now()->addDays($this->faker->numberBetween(0, 10)),
            'start_at' => sprintf('%s:00', $this->faker->numberBetween(8,11)),
            'end_at' => sprintf('%s:00', $this->faker->numberBetween(15,20)),
            'employee_id' => Employee::inRandomOrder()->first()->id,
        ];
    }
}
