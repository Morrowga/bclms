<?php

namespace Src\BlendedConcept\User\Domain\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\BlendedConcept\User\Domain\Model\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
        ];
    }
}
