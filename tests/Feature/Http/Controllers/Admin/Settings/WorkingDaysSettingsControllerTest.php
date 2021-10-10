<?php

namespace Tests\Feature\Http\Controllers\Admin\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkingDaysSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/settings/working-days');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.settings.working-days.form')
            ->assertSee('График работы')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/settings/working-days', [
            'monday' => ['08:00', '18:00'],
            'tuesday' => ['08:00', '16:00'],
            'wednesday' => ['08:00', '18:00'],
            'thursday' => ['08:00', '18:00'],
            'friday' => ['08:00', '18:00'],
            'saturday' => ['08:00', '18:00'],
            'sunday' => ['08:00', '18:00'],
        ]);

        $this->assertDatabaseHas('settings', [
            'group' => 'working_days',
            'name' => 'monday',
            'payload' => "[\"08:00\",\"18:00\"]",
        ]);

        $this->assertDatabaseHas('settings', [
            'group' => 'working_days',
            'name' => 'tuesday',
            'payload' => "[\"08:00\",\"16:00\"]",
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testUpdateValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->put('/admin/settings/working-days', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'monday' => '',
                    'tuesday' => '',
                    'wednesday' => '',
                    'thursday' => '',
                    'friday' => '',
                    'saturday' => '',
                    'sunday' => '',
                ],
                [
                    'monday' => 'Поле Понедельник обязательно для заполнения.',
                    'tuesday' => 'Поле Вторник обязательно для заполнения.',
                    'wednesday' => 'Поле Среда обязательно для заполнения.',
                    'thursday' => 'Поле Четверг обязательно для заполнения.',
                    'friday' => 'Поле Пятница обязательно для заполнения.',
                    'saturday' => 'Поле Суббота обязательно для заполнения.',
                    'sunday' => 'Поле Воскресенье обязательно для заполнения.',
                ]
            ],
            'array rule' => [
                [
                    'monday' => 'q',
                    'tuesday' => 'q',
                    'wednesday' => 'q',
                    'thursday' => 'q',
                    'friday' => 'q',
                    'saturday' => 'q',
                    'sunday' => 'q',
                ],
                [
                    'monday' =>  'Поле Понедельник должно быть массивом.',
                    'tuesday' =>  'Поле Вторник должно быть массивом.',
                    'wednesday' =>  'Поле Среда должно быть массивом.',
                    'thursday' =>  'Поле Четверг должно быть массивом.',
                    'friday' =>  'Поле Пятница должно быть массивом.',
                    'saturday' =>  'Поле Суббота должно быть массивом.',
                    'sunday' =>  'Поле Воскресенье должно быть массивом.',
                ]
            ],
            'date format rule' => [
                [
                    'monday' => ['1100', '1200'],
                    'tuesday' => ['1100', '1200'],
                    'wednesday' => ['1100', '1200'],
                    'thursday' => ['1100', '1200'],
                    'friday' => ['1100', '1200'],
                    'saturday' => ['1100', '1200'],
                    'sunday' => ['1100', '1200'],
                ],
                [
                    'monday.0' =>  'Поле Время начала рабочего дня понедельника не соответствует формату H:i.',
                    'monday.1' =>  'Поле Время окончания рабочего дня понедельника не соответствует формату H:i.',
                    'tuesday.0' =>  'Поле Время начала рабочего дня вторника не соответствует формату H:i.',
                    'tuesday.1' =>  'Поле Время окончания рабочего дня вторника не соответствует формату H:i.',
                    'wednesday.0' =>  'Поле Время начала рабочего дня среды не соответствует формату H:i.',
                    'wednesday.1' =>  'Поле Время окончания рабочего дня среды не соответствует формату H:i.',
                    'thursday.0' =>  'Поле Время начала рабочего дня четверга не соответствует формату H:i.',
                    'thursday.1' =>  'Поле Время окончания рабочего дня четверга не соответствует формату H:i.',
                    'friday.0' =>  'Поле Время начала рабочего дня пятницы не соответствует формату H:i.',
                    'friday.1' =>  'Поле Время окончания рабочего дня пятницы не соответствует формату H:i.',
                    'saturday.0' =>  'Поле Время начала рабочего дня субботы не соответствует формату H:i.',
                    'saturday.1' =>  'Поле Время окончания рабочего дня субботы не соответствует формату H:i.',
                    'sunday.0' =>  'Поле Время начала рабочего дня воскресенья не соответствует формату H:i.',
                    'sunday.1' =>  'Поле Время окончания рабочего дня воскресенья не соответствует формату H:i.',
                ]
            ],
        ];
    }
}
