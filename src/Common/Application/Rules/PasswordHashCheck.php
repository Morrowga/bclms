<?php

namespace Src\Common\Application\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PasswordHashCheck implements Rule
{
    public function passes($attribute, $value)
    {
        // Retrieve the user's hashed password from the database
        $user = auth()->user(); // You may need to adjust how you get the user
        $hashedPassword = $user->password;

        // Check if the provided password matches the hashed password
        return Hash::check($value, $hashedPassword);
    }

    public function message()
    {
        return 'The provided password is incorrect.';
    }
}
