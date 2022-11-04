<?php

declare(strict_types=1);

namespace App\Core\Application;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
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

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
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

    protected function autoValidateRequest(): bool
    {
        return true;
    }

    #[NoReturn]
    protected function sendResponse(array $messages): void
    {
        $response = new JsonResponse($messages, 400);
        $response->send();

        exit;
    }
}