<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \JsonException
     */
    public function run(): void
    {
        $sections = json_decode(file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . 'services.json'
        ), true, 512, JSON_THROW_ON_ERROR);

        foreach ($sections as $sectionName => $categories){
            $section = Section::factory()->create([
                'name' => $sectionName,
            ]);
            foreach($categories as $categoryName => $services) {
                $category = Category::factory()->create([
                    'name' => $categoryName,
                ]);

                $category->sections()->attach($section->id);

                foreach($services as $service) {
                    $service = Service::factory()->create([
                        'name' => $service['name'],
                        'duration' => $service['duration'],
                        'price' => $service['price'],
                    ]);

                    $service->categories()->attach($category->id);
                }
            }
        }
    }
}
