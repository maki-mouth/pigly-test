<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WeightLog;
use App\Models\User;
use Carbon\Carbon;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDate = Carbon::now()->subDays(rand(1, 60));

        $weight = $this->faker->randomFloat(1, 50.0, 80.0);

        $calories = $this->faker->numberBetween(1000, 3000);

        $exerciseTime = $this->faker->time('H:i', '02:00');

        return [
            // Seeder側で特定のユーザーに紐づけるため、ここではプレースホルダーとしておく
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'date' => $randomDate->format('Y-m-d'),
            'weight' => $weight,
            'calories' => $calories,
            'exercise_time' => $exerciseTime,
            'exercise_content' => $this->faker->realText(50),
        ];
    }
}