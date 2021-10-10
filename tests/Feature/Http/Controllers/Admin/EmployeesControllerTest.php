<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployeesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/employees');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.employees.index')
            ->assertSee('Сотрудники')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/employees');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/employees/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.employees.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $position = Position::factory()->create();
        $service = Service::factory()->create();

        $this->post('/admin/employees', [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position_id' => $position->id,
            'service_ids' => [$service->id]
        ]);

        $this->assertDatabaseHas(Employee::class, [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position_id' => $position->id,
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();

        Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->post('/admin/employees', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'name' => '',
                    'email' => '',
                    'position_id' => '',
                ],
                [
                    'name' => 'Поле Имя обязательно для заполнения.',
                    'email' => 'Поле E-Mail адрес обязательно для заполнения.',
                    'position_id' => 'Поле Должность обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'name' => '2',
                ],
                [
                    'name' => 'Количество символов в поле Имя должно быть не менее 2.',
                ]
            ],
            'max rule' => [
                [
                    'name' => Str::random(256),
                ],
                [
                    'name' => 'Количество символов в поле Имя не может превышать 255.',
                ]
            ],
            'email rule' => [
                [
                    'email' => 'qweqwe',
                ],
                [
                    'email' => 'Поле E-Mail адрес должно быть действительным электронным адресом.',
                ]
            ],
            'unique rule' => [
                [
                    'email' => 'test@email.com',
                ],
                [
                    'email' => 'Такое значение поля E-Mail адрес уже существует.',
                ]
            ],
            'exists rule' => [
                [
                    'position_id' => 2,
                    'service_ids' => [1],
                ],
                [
                    'position_id' => 'Выбранное значение для Должность некорректно.',
                    'service_ids.0' => 'Выбранное значение для Оказываемой услуги некорректно.',
                ]
            ],
        ];
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();

        $employee = Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->get('/admin/employees/' . $employee->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.employees.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $position = Position::factory()->create();
        $service = Service::factory()->create();

        $employee = Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $this->put('/admin/employees/' . $employee->id, [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position_id' => $position->id,
            'service_ids' => [$service->id]
        ]);

        $this->assertDatabaseHas(Employee::class, [
            'name' => 'Test',
            'email' => 'test@test.com',
            'position_id' => $position->id,
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        Position::factory()->create();
        $employee = Employee::factory()->create([
            'email' => 'test@email.com'
        ]);

        $this->delete('/admin/employees/' . $employee->id);

        $this->assertDatabaseMissing(Employee::class, [
            'id' => $employee->id,
            'email' => 'test@email.com',
        ]);
    }
}
