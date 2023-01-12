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
        //TODO: create universal mechanism of exception processing
        if ($data instanceof DomainException) {
            $code = 400;
            if (0 !== (int)$data->getCode()) {
                $code = $data->getCode();
            }

            return parent::json($data->getContent(), $code, $headers, $context);
        }

        return parent::json($data, $status, $headers, $context);
    }
}
