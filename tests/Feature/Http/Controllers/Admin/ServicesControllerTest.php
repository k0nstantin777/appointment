<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ServicesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/services');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.services.index')
            ->assertSee('Услуги')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/services');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/services/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.services.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->post('/admin/services', [
            'name' => 'Test',
            'duration' => '01:30',
            'price' => '500',
            'category_ids' => [$category->id],
            'description' => null,
        ]);

        $this->assertDatabaseHas(Service::class, [
            'name' => 'Test',
            'duration' => '01:30',
            'price' => '500',
            'description' => '',
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Service::factory()->create([
            'name' => 'Test'
        ]);

        $response = $this->post('/admin/services', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'name' => '',
                    'duration' => '',
                    'price' => '',
                    'category_ids' => [''],
                ],
                [
                    'name' => 'Поле Имя обязательно для заполнения.',
                    'duration' => 'Поле Длительность обязательно для заполнения.',
                    'price' => 'Поле Стоимость обязательно для заполнения.',
                    'category_ids.0' => 'Поле Привязанная категория обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'name' => '2',
                    'description' => '1',
                ],
                [
                    'name' => 'Количество символов в поле Имя должно быть не менее 2.',
                    'description' => 'Количество символов в поле Описание должно быть не менее 2.',
                ]
            ],
            'max rule' => [
                [
                    'name' => Str::random(256),
                    'description' => Str::random(1001),
                ],
                [
                    'name' => 'Количество символов в поле Имя не может превышать 255.',
                    'description' => 'Количество символов в поле Описание не может превышать 1000.',
                ]
            ],
            'unique rule' => [
                [
                    'name' => 'Test',
                ],
                [
                    'name' => 'Такое значение поля Имя уже существует.',
                ]
            ],
            'date_format rule' => [
                [
                    'duration' => '1100',
                ],
                [
                    'duration' => 'Поле Длительность не соответствует формату H:i.',
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
            'array rule' => [
                [
                    'category_ids' => 'q',
                ],
                [
                    'category_ids' => 'Поле Привязанные категории должно быть массивом.',
                ]
            ],
            'exists rule' => [
                [
                    'category_ids' => [1],
                ],
                [
                    'category_ids.0' => 'Выбранное значение для Привязанная категория некорректно.',
                ]
            ],
        ];
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Service::factory()->create([
            'name' => 'Test'
        ]);

        $response = $this->get('/admin/services/' . $section->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.services.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Service::factory()->create([
            'name' => 'Test'
        ]);

        $category = Category::factory()->create();

        $this->put('/admin/services/' . $section->id, [
            'name' => 'Test1',
            'duration' => '01:30',
            'price' => '500',
            'category_ids' => [$category->id],
            'description' => 'test description',
        ]);

        $this->assertDatabaseHas(Service::class, [
            'name' => 'Test1',
            'description' => 'test description',
            'duration' => '01:30',
            'price' => '500',
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Service::factory()->create([
            'name' => 'Test'
        ]);

        $this->delete('/admin/services/' . $section->id);

        $this->assertDatabaseMissing(Service::class, [
            'id' => $section->id,
            'name' => 'Test'
        ]);
    }
}
