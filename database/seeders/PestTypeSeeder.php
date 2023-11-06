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
        PestType::factory(25)->create();
    }
}
