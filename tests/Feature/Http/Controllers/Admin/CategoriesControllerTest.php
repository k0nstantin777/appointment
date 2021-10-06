<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/categories');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.categories.index')
            ->assertSee('Категории')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/categories');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/categories/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.categories.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Section::factory()->create();
        $category = Category::factory()->create();

        $this->post('/admin/categories', [
            'name' => 'TestCategory',
            'description' => 'Test description',
            'section_ids' => [$section->id],
            'parent_category_id' => $category->id,
        ]);

        $this->assertDatabaseHas(Category::class, [
            'name' => 'TestCategory',
            'description' => 'Test description',
            'parent_id' => $category->id,
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/admin/categories', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'name' => '',
                ],
                [
                    'name' => 'Поле Имя обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'name' => '2',
                    'description' => 'ы',
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
            'array rule' => [
                [
                    'section_ids' => '',
                ],
                [
                    'section_ids' => 'Поле Привязанные разделы должно быть массивом.',
                ]
            ],
            'exist rule' => [
                [
                    'parent_category_id' => 1,
                ],
                [
                    'parent_category_id' => 'Выбранное значение для Родительская категория некорректно.',
                ]
            ],
        ];
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $response = $this->get('/admin/categories/' . $category->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.categories.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Section::factory()->create();
        $category = Category::factory()->create();

        $this->put('/admin/categories/' . $category->id, [
            'name' => 'TestCategory',
            'description' => 'Test description',
            'section_ids' => [$section->id],
        ]);

        $this->assertDatabaseHas(Category::class, [
            'name' => 'TestCategory',
            'description' => 'Test description',
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create([
            'name' => 'TestCategory',
            'description' => 'Test description',
        ]);

        $this->delete('/admin/categories/' . $category->id);

        $this->assertDatabaseMissing(Category::class, [
            'name' => 'TestCategory',
            'description' => 'Test description',
        ]);
    }
}
