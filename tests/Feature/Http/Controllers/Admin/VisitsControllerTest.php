<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\DataTransferObjects\StoreWorkingDaysSettingsDto;
use App\Enums\VisitStatus;
use App\Models\Category;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Service;
use App\Models\Visit;
use App\Models\User;
use App\Models\WorkingDay;
use App\Services\Entities\Settings\WorkingDaysSettingsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/visits');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.visits.index')
            ->assertSee('Визиты')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/visits');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/visits/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.visits.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2021-01-01');

        Position::factory()->create();
        $employee = Employee::factory()->create();

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        WorkingDaysSettingsService::getInstance()->update(new StoreWorkingDaysSettingsDto(
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
        ));

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);

        $client = Client::factory()->create();

        $this->post('/admin/visits', [
            'visit_date' => '2021-05-21',
            'visit_start_at' => '08:30',
            'visit_end_at' => '10:30',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        $this->assertDatabaseHas(Visit::class, [
            'visit_date' => Carbon::parse('2021-05-21')->toDateTimeString(),
            'start_at' => Carbon::parse('08:30')->toDateTimeString(),
            'end_at' => Carbon::parse('10:30')->toDateTimeString(),
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => 'new',
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2021-01-31 10:00:00');

        $response = $this->post('/admin/visits', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'visit_date' => '',
                    'visit_start_at' => '',
                    'visit_end_at' => '',
                    'employee_id' => '',
                    'service_id' => '',
                    'client_id' => '',
                    'price' => '',
                    'status' => '',
                ],
                [
                    'visit_date' => 'Поле Дата визита обязательно для заполнения.',
                    'visit_start_at' => 'Поле Начало визита обязательно для заполнения.',
                    'visit_end_at' => 'Поле Окончание визита обязательно для заполнения.',
                    'employee_id' => 'Поле Сотрудник обязательно для заполнения.',
                    'service_id' => 'Поле Услуга обязательно для заполнения.',
                    'client_id' => 'Поле Клиент обязательно для заполнения.',
                    'price' => 'Поле Стоимость обязательно для заполнения.',
                    'status' => 'Поле Статус обязательно для заполнения.',
                ]
            ],
            'date and date_format rules' => [
                [
                    'visit_date' => '1100',
                    'visit_start_at' => '1100',
                    'visit_end_at' => '1100',
                ],
                [
                    'visit_date' => 'Поле Дата визита не является датой.',
                    'visit_start_at' => 'Поле Начало визита не соответствует формату H:i.',
                    'visit_end_at' => 'Поле Окончание визита не соответствует формату H:i.',
                ]
            ],
            'numeric rule' => [
                [
                    'price' => 'q',
                ],
                [
                    'price' => 'Поле Стоимость должно быть числом.',
                ]
            ],
            'exists rule' => [
                [
                    'employee_id' => 1,
                    'service_id' => 1,
                    'client_id' => 1,
                ],
                [
                    'employee_id' => 'Выбранное значение для Сотрудник некорректно.',
                    'service_id' => 'Выбранное значение для Услуга некорректно.',
                    'client_id' => 'Выбранное значение для Клиент некорректно.',
                ]
            ],
            'after_or_equal rule' => [
                [
                    'visit_date' => '2021-01-30',
                ],
                [
                    'visit_date' => 'В поле Дата визита должна быть дата после или равняться 2021-01-31.',
                ]
            ],
            'after rule' => [
                [
                    'visit_start_at' => '11:00',
                    'visit_end_at' => '11:00',
                ],
                [
                    'visit_end_at' => 'В поле Окончание визита должна быть дата после Начало визита.',
                ]
            ],
            'in rule' => [
                [
                    'status' => '1100',
                ],
                [
                    'status' => 'Выбранное значение для Статус ошибочно.',
                ]
            ],
        ];
    }

    public function testStoreValidateIsWorkDayRule(): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2021-10-01 10:00:00');

        WorkingDaysSettingsService::getInstance()->update(new StoreWorkingDaysSettingsDto(
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            [null, null], //sunday
        ));

        $response = $this->post('/admin/visits', [
            'visit_date' => '2021-10-10', //sunday
        ]);

        $response->assertSessionHasErrors([
            'visit_date' => 'В выбранную дату - выходной',
        ]);
    }

    public function testStoreValidateIsWorkTimeWhenDayOffRule(): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2021-10-01 10:00:00');

        WorkingDaysSettingsService::getInstance()->update(new StoreWorkingDaysSettingsDto(
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            [null, null], //sunday
        ));

        $response = $this->post('/admin/visits', [
            'visit_date' => '2021-10-10', //sunday
            'visit_start_at' => '11:00',
            'visit_end_at' => '12:00',
        ]);

        $response->assertSessionHasErrors([
            'visit_start_at' => 'В данное время компания не работает',
            'visit_end_at' => 'В данное время компания не работает',
        ]);
    }

    public function testStoreValidateIsWorkTimeWhenTimeOffRule(): void
    {
        $this->actingAs(User::factory()->create());

        WorkingDaysSettingsService::getInstance()->update(new StoreWorkingDaysSettingsDto(
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['10:00', '12:00'],
        ));

        $response = $this->post('/admin/visits', [
            'visit_date' => '2021-10-10', //sunday
            'visit_start_at' => '09:59',
            'visit_end_at' => '12:01',
        ]);

        $response->assertSessionHasErrors([
            'visit_start_at' => 'В данное время компания не работает',
            'visit_end_at' => 'В данное время компания не работает',
        ]);
    }

    public function testStoreValidateIsWillWorkEmployeeRule(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        $response = $this->post('/admin/visits', [
            'employee_id' => $employee->id,
            'visit_date' => '2021-05-20',
            'visit_start_at' => '09:59',
            'visit_end_at' => '11:01',
        ]);

        $response->assertSessionHasErrors([
            'employee_id' => 'В выбранную дату и время данный сотрудник не работает',
        ]);
    }

    public function testStoreValidateIsEmployeeCanServiceRule(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        $response = $this->post('/admin/visits', [
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'visit_date' => '2021-05-21',
            'visit_start_at' => '09:59',
            'visit_end_at' => '11:01',
        ]);

        $response->assertSessionHasErrors([
            'employee_id' => 'Данный сотрудник не оказывает выбранную услугу.',
        ]);
    }

    public function testStoreValidateIsEmployeeHasFreeTimeWhenOneIntersectVisitsRule(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);
        $client = Client::factory()->create();

        Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '8:30',
            'end_at' => '10:00',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        $response = $this->post('/admin/visits', [
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'visit_date' => '2021-05-21',
            'visit_start_at' => '09:59',
            'visit_end_at' => '11:01',
        ]);

        $response->assertSessionHasErrors([
            'employee_id' => 'У данного сотрудника выбранное время занято.',
        ]);
    }

    public function testStoreValidateIsEmployeeHasFreeTimeWhenTwoIntersectVisitsRule(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);
        $client = Client::factory()->create();

        Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '8:30',
            'end_at' => '09:59',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '10:30',
            'end_at' => '11:01',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        $response = $this->post('/admin/visits', [
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'visit_date' => '2021-05-21',
            'visit_start_at' => '09:59',
            'visit_end_at' => '11:01',
        ]);

        $response->assertSessionHasErrors([
            'employee_id' => 'У данного сотрудника выбранное время занято.',
        ]);
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);
        $client = Client::factory()->create();

        $visit = Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '8:30',
            'end_at' => '09:59',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        $response = $this->get('/admin/visits/' . $visit->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.visits.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2021-01-01');

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);
        $client = Client::factory()->create();

        WorkingDay::factory()->create([
            'employee_id' => $employee->id,
            'calendar_date' => '2021-05-21',
            'start_at' => '08:00',
            'end_at' => '18:00',
        ]);

        WorkingDaysSettingsService::getInstance()->update(new StoreWorkingDaysSettingsDto(
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
            ['08:00', '18:00'],
        ));

        $visit = Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '08:30',
            'end_at' => '09:59',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        $this->put('/admin/visits/' . $visit->id, [
            'visit_date' => '2021-05-21',
            'visit_start_at' => '08:30',
            'visit_end_at' => '10:30',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 600,
            'status' => VisitStatus::NEW,
        ]);

        $this->assertDatabaseHas(Visit::class, [
            'visit_date' => Carbon::parse('2021-05-21')->toDateTimeString(),
            'start_at' => Carbon::parse('08:30')->toDateTimeString(),
            'end_at' => Carbon::parse('10:30')->toDateTimeString(),
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 600,
            'status' => 'new',
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();
        $employee->services()->attach($service->id);
        $client = Client::factory()->create();

        $visit = Visit::create([
            'visit_date' => '2021-05-21',
            'start_at' => '8:30',
            'end_at' => '09:59',
            'employee_id' => $employee->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'price' => 500,
            'status' => VisitStatus::NEW,
        ]);

        $this->delete('/admin/visits/' . $visit->id);

        $this->assertDatabaseMissing(Visit::class, [
            'id' => $visit->id,
        ]);
    }
}
