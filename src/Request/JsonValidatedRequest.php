<?php

declare(strict_types=1);

namespace App\Request;

use App\Validation\ValidationErrorList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class JsonValidatedRequest
{
    public function __construct(
        protected readonly ValidatorInterface  $validator,
        protected readonly TranslatorInterface $translator,
    )
    {
        $this->populate($this->getRequest()->getContent());

        if ($this->autoValidateRequest()) {
            $this->validate($this->getRequest()->getLocale());
        }
    }

    protected function populate(mixed $rawContent): void
    {
        $content = json_decode($rawContent);

        if (null === $content) {
            $this->sendResponse(['message' => 'Invalid json provided']);
        }

        foreach ($content as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function sendResponse(array $messages): void
    {
        $response = new JsonResponse($messages, 400);
        $response->send();

        exit;
    }

    protected function autoValidateRequest(): bool
    {
        return true;
    }

    public function validate(string $locale): void
    {
        $errors = $this->validator->validate($this);

        $validationResponse = new ValidationErrorList($errors, $this->translator, $locale);

        if ($validationResponse->hasErrors()) {
            $this->sendResponse(
                $validationResponse->getContent()
            );
        }
    }
}
