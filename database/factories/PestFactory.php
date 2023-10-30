<?php

namespace Database\Factories;

use App\Models\PestType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pest>
 */
class PestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pest_type_id' => PestType::all()->random()->id
        ];
    }
}
