<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'title' => 'Honda Brio',
                'brand' => 'Honda',
                'price' => 2000000,
                'period' => 'weekly',
                'gearbox' => 'automatic',
                'color' => 'red',
                'speed' => 400,
                'images' => 
            ],
        ];
    }
}
