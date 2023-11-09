<?php

namespace Database\Seeders;

use App\Models\PestImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PestImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PestImage::factory(15)->create()
        ->each(function($pestImage) {
            // Add random photo for each product
            $pestImage
                ->addMediaFromUrl('https://picsum.photos/200')
                ->toMediaCollection('pest_image_photos');
        });
    }
}
