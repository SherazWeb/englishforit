<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Module;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
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
            'module_id' => Module::inRandomOrder()->first()?->id ?? Module::factory(),
            'order' => $order++,
            'slug' => Str::slug(fake()->unique()->sentence(4)),
            'title' => fake()->unique()->sentence(4),
            'summary' => fake()->optional()->paragraph,
            'is_premium' => fake()->boolean(30), // 30% chance true

            // Listening Section
            'listening_audio_path' => 'audio/sample-' . fake()->numberBetween(1, 10) . '.mp3',
            'listening_transcript' => fake()->optional()->paragraphs(3, true),

            // Reading Section
            'reading_content' => fake()->paragraphs(5, true),
            'reading_vocabulary' => fake()->optional()->randomElements([
                ['word' => 'analyze', 'meaning' => 'to examine in detail'],
                ['word' => 'interpret', 'meaning' => 'to explain the meaning of something'],
                ['word' => 'comprehend', 'meaning' => 'to understand'],
            ], 3),
        ];
    }
}
