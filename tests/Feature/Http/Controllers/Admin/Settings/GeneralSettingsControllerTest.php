<?php

namespace Tests\Feature\Http\Controllers\Admin\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class GeneralSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/settings/general');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.settings.general.form')
            ->assertSee('Настройки приложения')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/settings/general', [
            'company_name' => 'Test Company',
            'timezone' => 'Europe/Moscow',
        ]);

        $this->assertDatabaseHas('settings', [
            'group' => 'general',
            'name' => 'company_name',
            'payload' => "\"Test Company\"",
        ]);

        $this->assertDatabaseHas('settings', [
            'group' => 'general',
            'name' => 'timezone',
            'payload' => "\"Europe\\/Moscow\"",
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testUpdateValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->put('/admin/settings/general', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'company_name' => '',
                    'timezone' => '',
                ],
                [
                    'company_name' => 'Поле Название компании обязательно для заполнения.',
                    'timezone' => 'Поле Временная зона обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'company_name' => 'й',
                ],
                [
                    'company_name' => 'Количество символов в поле Название компании должно быть не менее 2.',
                ]
            ],
            'max rule' => [
                [
                    'company_name' => Str::random(51),
                ],
                [
                    'company_name' => 'Количество символов в поле Название компании не может превышать 50.',
                ]
            ],
            'string rule' => [
                [
                    'company_name' => true,
                ],
                [
                    'company_name' => 'Поле Название компании должно быть строкой.',
                ]
            ],
            'timezone rule' => [
                [
                    'timezone' => 'Moscow',
                ],
                [
                    'timezone' => 'Поле Временная зона должно быть действительным часовым поясом.',
                ]
            ],
        ];
    }
}
