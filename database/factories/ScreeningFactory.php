<?php

namespace Database\Factories;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Screening>
 */
class ScreeningFactory extends Factory
{
    protected $model = Screening::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'mahasiswa']),
            'narrative' => fake()->realText(150),
            'emotion_label' => fake()->randomElement(['Anger', 'Fear', 'Sadness', 'Non-distress Emosional']),
            'emotion_confidence' => fake()->randomFloat(4, 0.5, 0.99),
            'hars_score' => fake()->numberBetween(0, 56),
            'risk_level' => fake()->randomElement(['rendah', 'sedang', 'tinggi']),
            'consent_followup' => false,
        ];
    }
}
