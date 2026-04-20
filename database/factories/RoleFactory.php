<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    public function definition(): array
    {
        $code = fake()->unique()->lexify('role_??????');

        return [
            'name' => ucfirst(str_replace('_', ' ', $code)),
            'code' => $code,
        ];
    }
}
