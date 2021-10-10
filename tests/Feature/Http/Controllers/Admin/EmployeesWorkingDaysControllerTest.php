<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeesWorkingDaysControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();

        $employee =  Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->get('/admin/employees/' . $employee->id . '/working-days/edit?filter-month=05&filter-year=2022');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.employees.working-days')
            ->assertSee('График работы сотрудника ' . $employee->name)
            ->assertSee('График на май, 2022')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee =  Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

         WorkingDay::factory()->create([
            'employee_id' => 1,
            'calendar_date' => '2021-12-03',
            'start_at' => '08:00',
            'end_at' => '16:00',
        ]);

         $this->put('/admin/employees/' . $employee->id . '/working-days/update', [
            'year' => '2021',
            'month' => '12',
            'start_days' => [1 => '08:00'],
            'end_days' => [1 => '18:00'],
            'day_offs' => [2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1, 7 => 1, 8 => 1, 9 => 1, 10 => 1, 11 => 1, 12 => 1,
                13 => 1, 14 => 1, 15 => 1, 16 => 1, 17 => 1, 18 => 1, 19 => 1, 20 => 1, 21 => 1, 22 => 1, 23 => 1,
                24 => 1, 25 => 1, 26 =>1, 27 => 1, 28 => 1, 29 => 1, 30 => 1, 31 => 1]
        ]);

        $this->assertDatabaseHas(WorkingDay::class, [
            'employee_id' => $employee->id,
            'calendar_date' => Carbon::parse('2021-12-01')->toDateTimeString(),
            'start_at' => Carbon::parse('08:00')->toDateTimeString(),
            'end_at' =>  Carbon::parse('18:00')->toDateTimeString(),
        ]);

        $this->assertDatabaseMissing(WorkingDay::class, [
            'employee_id' => $employee->id,
            'calendar_date' => '2021-12-03',
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testUpdateValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();

        Carbon::setTestNow('2021-10-09 18:00');

        $employee = Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->put('/admin/employees/' . $employee->id . '/working-days/update', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'year' => '',
                    'month' => '',
                    'start_days' => '',
                    'end_days' => '',
                    'day_offs' => '',
                ],
                [
                    'year' => 'Поле Год обязательно для заполнения.',
                    'month' => 'Поле Месяц обязательно для заполнения.',
                    'start_days' => 'Поле Время начала рабочих дней обязательно для заполнения.',
                    'end_days' => 'Поле Время окончания рабочих дней обязательно для заполнения.',
                    'day_offs' => 'Поле Выходные дни обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'year' => '2020',
                    'month' => '0',
                ],
                [
                    'year' => 'Поле Год должно быть не менее 2021.',
                    'month' => 'Поле Месяц должно быть не менее 1.',
                ]
            ],
            'max rule' => [
                [
                    'year' => '2023',
                    'month' => '13',
                ],
                [
                    'year' => 'Поле Год не может быть более 2022.',
                    'month' => 'Поле Месяц не может быть более 12.',
                ]
            ],
            'array rule' => [
                [
                    'start_days' => 'qweqwe',
                    'end_days' => 'qweqwe',
                    'day_offs' => 'qweqwe',
                ],
                [
                    'start_days' => 'Поле Время начала рабочих дней должно быть массивом.',
                    'end_days' => 'Поле Время окончания рабочих дней должно быть массивом.',
                    'day_offs' => 'Поле Выходные дни должно быть массивом.',
                ]
            ],
            'date format rule' => [
                [
                    'start_days' => [1 => '1100'],
                    'end_days' => [1 => '1800'],
                ],
                [
                    'start_days.1' => 'Поле Время начала рабочего дня не соответствует формату H:i.',
                    'end_days.1' => 'Поле Время окончания рабочего дня не соответствует формату H:i.',
                ]
            ],
            'numeric rule' => [
                [
                    'day_offs' => [1 => 'q'],
                ],
                [
                    'day_offs.1' => 'Поле Выходной день должно быть числом.',
                ]
            ],
        ];
    }
}
