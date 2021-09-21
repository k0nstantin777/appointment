<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            'Парикмахер',
            'Мастер маникюра',
            'Массажист'
        ];

        foreach ($positions as $position) {
            Position::factory()->create([
                'name' => $position,
            ]);
        }
    }
}
