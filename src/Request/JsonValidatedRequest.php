<?php

declare(strict_types=1);

namespace App\Request;

use App\Validation\ValidationErrorList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class JsonValidatedRequest
{
    public function __construct(
        protected readonly ValidatorInterface $validator
    )
    {
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    protected function populate(): void
    {
        $content = json_decode($this->getRequest()->getContent());

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

    public function validate(): void
    {
        $errors = $this->validator->validate($this);

        $validationResponse = new ValidationErrorList($errors);

        if ($validationResponse->hasErrors()) {
            $this->sendResponse(
                $validationResponse->getContent()
            );
        }
    }
}
