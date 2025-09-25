<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Task;

class TasksPerUser implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskCount = Task::where('user_id', $value)->count();

        if ($taskCount >= 5) {
            $fail('El usuario ya tiene el número máximo de tareas permitidas (5).');
        }
    }
}
