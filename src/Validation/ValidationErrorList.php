<?php

declare(strict_types=1);

namespace App\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ValidationErrorList
{
    protected const MESSAGE = 'validation_failed';

    /**
     * @var array<string, array<string, string>>
     */
    private array $errorList = [];

    public function __construct(
        ConstraintViolationListInterface     $constraintViolationList,
        private readonly TranslatorInterface $translator,
        private readonly string              $locale,
    )
    {
        foreach ($constraintViolationList as $message) {
            $this->errorList[] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $this->translator->trans(
                    id: $message->getMessage(),
                    domain: 'validators',
                    locale: $this->locale
                ),
                'code' => $message->getCode(),
            ];
        }
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return ['message' => static::MESSAGE, 'list' => $this->errorList];
    }

    public function hasErrors(): bool
    {
        return count($this->errorList) > 0;
    }
}
