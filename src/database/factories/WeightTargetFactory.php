<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\WeightTarget;
use App\Models\User;


class WeightTargetFactory extends Factory
{
    protected $model = WeightTarget::class;
    /**
    * @return array
    */
    public function definition()
    {
        $targetWeight = $this->faker->randomFloat(1, 45.0, 75.0);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'target_weight' => $targetWeight,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
