<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Client;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/clients');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.clients.index')
            ->assertSee('Клиенты')
        ;
    }

    public function testIndexNotAuthenticate(): void
    {
        $response = $this->get('/admin/clients');

        $response->assertStatus(302);
    }

    public function testCreate(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/clients/create');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.clients.form')
        ;
    }

    public function testStore(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/admin/clients', [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '+711233',
        ]);

        $this->assertDatabaseHas(Client::class, [
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '+711233',
        ]);
    }

    /**
     * @dataProvider validateRequestDataProvider
     */
    public function testStoreValidateRequest($data, $expected): void
    {
        $this->actingAs(User::factory()->create());

        Client::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->post('/admin/clients', $data);

        $response->assertSessionHasErrors($expected);
    }

    public function validateRequestDataProvider(): array
    {
        return [
            'required rule' => [
                [
                    'name' => '',
                    'email' => '',
                    'phone' => '',
                ],
                [
                    'name' => 'Поле Имя обязательно для заполнения.',
                    'email' => 'Поле E-Mail адрес обязательно для заполнения.',
                    'phone' => 'Поле Телефон обязательно для заполнения.',
                ]
            ],
            'min rule' => [
                [
                    'name' => '2',
                    'phone' => 'ы',
                ],
                [
                    'name' => 'Количество символов в поле Имя должно быть не менее 2.',
                    'phone' => 'Количество символов в поле Телефон должно быть не менее 2.',
                ]
            ],
            'max rule' => [
                [
                    'name' => Str::random(256),
                    'phone' => Str::random(256),
                ],
                [
                    'name' => 'Количество символов в поле Имя не может превышать 255.',
                    'phone' => 'Количество символов в поле Телефон не может превышать 255.',
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
        ];
    }

    public function testEdit(): void
    {
        $this->actingAs(User::factory()->create());

        $client = Client::factory()->create([
            'email' => 'test@email.com'
        ]);

        $response = $this->get('/admin/clients/' . $client->id .  '/edit');

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.clients.form')
        ;
    }

    public function testUpdate(): void
    {
        $this->actingAs(User::factory()->create());

        $client = Client::factory()->create([
            'email' => 'test@email.com'
        ]);

        $this->put('/admin/clients/' . $client->id, [
            'name' => 'Test',
            'email' => 'test@email.com',
            'phone' => '+78128883123'
        ]);

        $this->assertDatabaseHas(Client::class, [
            'name' => 'Test',
            'email' => 'test@email.com',
            'phone' => '+78128883123'
        ]);
    }

    public function testDelete(): void
    {
        $this->actingAs(User::factory()->create());

        $client = Client::factory()->create([
            'email' => 'test@email.com'
        ]);


        $this->delete('/admin/clients/' . $client->id);

        $this->assertDatabaseMissing(Client::class, [
            'id' => $client->id,
            'email' => 'test@email.com',
        ]);
    }
}
