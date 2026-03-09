<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'make' => $this->faker->company(),
            'year' => $this->faker->year(),
            'brand' => $this->faker->company(),
            'license_plate' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{4}'),
            'created_by' => User::factory(),
        ];
    }
}
