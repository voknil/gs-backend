<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class BaseApiController
 *
 * @package App\Controller
 *
 * @Route("/api")
 */
class BaseApiController extends AbstractController
{
    /**
     * @var string
     */
    private $response = 'pong';

    /**
     * Check api health
     *
     * Use this method to check that api works
     *
     * @Route("/ping", name="api_health", methods={"GET"})
     *
     * @SWG\Tag(name="system")
     *
     * @SWG\Response(
     *     response=200,
     *     description="success",
     *     examples={
     *     "application/json": "pong"
     *   }
     * )
     *
     * @return JsonResponse
     */
    public function ping(): JsonResponse
    {
        return new JsonResponse($this->response);
    }
}
