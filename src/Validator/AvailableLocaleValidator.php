<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AvailableLocaleValidator extends ConstraintValidator
{
    /**
     * @param string[] $availableLocales
     */
    public function __construct(
        private readonly array $availableLocales,
    )
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof AvailableLocale) {
            throw new UnexpectedTypeException($constraint, AvailableLocale::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }


        if (!in_array($value, $this->availableLocales, true)) {
            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
