<?php

namespace Database\Seeders;

use App\Models\Pest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pest::factory(25)->create()->each(function ($pest) {
            // Add random photo for each product
            $pest
                ->addMediaFromUrl('https://picsum.photos/200')
                ->toMediaCollection('pest_photos');
        });
    }
}
