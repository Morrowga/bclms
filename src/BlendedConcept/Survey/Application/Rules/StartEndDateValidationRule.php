<?php

namespace Src\BlendedConcept\Survey\Application\Rules;

use Illuminate\Contracts\Validation\Rule;

class StartEndDateValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        // dd(request()->input('start_date') !== request()->input('end_date'));
        // Get the input data and validate that the start_date and end_date are not the same
        return request()->input('start_date') !== request()->input('end_date');
    }

    public function message()
    {
        return 'The start date and end_date cannot be the same.';
    }
}
