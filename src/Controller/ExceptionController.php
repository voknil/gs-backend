<?php


namespace App\Controller;


use App\Exception\Enum;
use App\Exception\PublicGsException;
use App\Exception\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ExceptionController
 *
 * @package App\Controller
 */
class ExceptionController
{
    /**
     * @param Exception $exception
     *
     * @return JsonResponse|null
     * @throws \Throwable
     */
    public function __invoke(\Throwable $exception): ?JsonResponse
    {
        if($exception instanceof ValidationException) {
            return new JsonResponse(
                [
                    'result' => false,
                    'errors' => $exception->getErrors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($exception instanceof PublicGsException){
            return new JsonResponse(
                [
                    'result' => false,
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof BadRequestHttpException){
            return new JsonResponse(
                [
                    'result' => false,
                    'errors' => Enum::BAD_REQUEST,
                ],
                Response::HTTP_BAD_REQUEST);
        } else {
            throw $exception;
        }
    }
}