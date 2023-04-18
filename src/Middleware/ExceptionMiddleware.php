<?php

namespace App\Middleware;

use App\Exception\DomainException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionMiddleware
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof DomainException) {
            $response = new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }
}
