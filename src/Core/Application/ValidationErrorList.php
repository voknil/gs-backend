<?php

declare(strict_types=1);

namespace App\Core\Application;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorList
{
    protected const MESSAGE = 'validation_failed';

    /**
     * @var array<string, array<string, string>>
     */
    private array $errorList = [];

    public function __construct(
        ConstraintViolationListInterface $constraintViolationList
    )
    {
        foreach ($constraintViolationList as $message) {
            $this->errorList[] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
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