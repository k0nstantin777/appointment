<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class SectionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/sections');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.sections.index')
            ->assertSee('Разделы')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/sections');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/sections/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.sections.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/admin/sections', [
            'name' => 'Test',
            'description' => null,
        ]);

        $this->assertDatabaseHas(Section::class, [
            'name' => 'Test',
            'description' => '',
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Section::factory()->create([
            'name' => 'Test'
        ]);

        $response = $this->post('/admin/sections', $data);

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
        ];
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Section::factory()->create([
            'name' => 'Test'
        ]);

        $response = $this->get('/admin/sections/' . $section->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.sections.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Section::factory()->create([
            'name' => 'Test'
        ]);

        $this->put('/admin/sections/' . $section->id, [
            'name' => 'Test1',
            'description' => 'test description'
        ]);

        $this->assertDatabaseHas(Section::class, [
            'name' => 'Test1',
            'description' => 'test description'
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        $section = Section::factory()->create([
            'name' => 'Test'
        ]);


        $this->delete('/admin/sections/' . $section->id);

        $this->assertDatabaseMissing(Section::class, [
            'id' => $section->id,
            'name' => 'Test'
        ]);
    }
}
