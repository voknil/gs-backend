<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class AvailableLocale extends Constraint
{
    public string $message = 'Locale "{{ string }}" is not available.';
}
