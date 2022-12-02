<?php

declare(strict_types=1);

namespace App\Request\Translation;

use App\Request\JsonValidatedRequest;
use App\Validator as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class SetUserLocale extends JsonValidatedRequest
{
    #[Assert\NotBlank]
    #[AppAssert\AvailableLocale]
    protected ?string $locale;

    public function getLocale(): string
    {
        return $this->locale;
    }
}
