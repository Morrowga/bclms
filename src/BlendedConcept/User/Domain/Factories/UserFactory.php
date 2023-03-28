<?php

namespace Src\BlendedConcept\User\Domain\Factories;

use Src\BlendedConcept\User\Domain\Model\User;

class UserFactory
{
    public static function new(array $attributes = null): User
    {
        $attributes = $attributes ?: [];

        $defaults = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => '$2a$12$LdqTOFbVgOsB3UuEjsLqcueEV2W/nE3u/1H8bb7zE8BqbZx.3m1VW'
        ];

        $attributes = array_replace($defaults, $attributes);

        return (new User([
            "name" => $attributes['name'],
            "email" => $attributes['email'],
            "password" => $attributes['password']
            ]
        ));
    }
}