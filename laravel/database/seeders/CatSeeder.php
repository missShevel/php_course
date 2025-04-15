<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Cat;


class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Cat::create([
            'name' => 'Whiskers',
            'age' => 2,
            'breed' => 'Siamese',
            'color' => 'Cream',
            'character' => 'Friendly',
        ]);

        Cat::create([
            'name' => 'Fluffy',
            'age' => 5,
            'breed' => 'Persian',
            'color' => 'White',
            'character' => 'Lazy',
        ]);
    }
}
