<?php

namespace Database\Seeders;

use App\Models\Pesticide;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesticideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pesticide::factory(25)->create();
    }
}
