<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $order = 1;

        return [
            'order' => $order++,
            'slug' => $this->faker->slug(3),
            'title' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->optional()->paragraph,
        ];
    }
}
