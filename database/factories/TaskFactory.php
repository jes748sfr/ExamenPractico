<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Company;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'is_completed' => $this->faker->boolean,
            'start_at' => $this->faker->dateTimeThisYear,
            'expired_at' => $this->faker->dateTimeThisYear,
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
