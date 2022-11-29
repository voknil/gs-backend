<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends AbstractController
{
    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($data instanceof DomainException) {
            return parent::json($data->getContent(), 400, $headers, $context);
        }

        return parent::json($data, $status, $headers, $context);
    }
}
