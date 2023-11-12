<?php

namespace Database\Seeders;

use App\Models\PestType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PestType::factory(25)->create()
        ->each(function($pestType) {
            // Add random photo for each product
            $pestType
                ->addMediaFromUrl('https://picsum.photos/200')
                ->toMediaCollection('pest_type_photos');
        });
    }
}
