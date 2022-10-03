<?php


namespace App\Controller\Api\V2\RequestHandlers\Test;


use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PingHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers\Test
 */
class PingHandler extends BaseApiHandler
{
    /**
     * @Route("/api/v2/ping", name="health_check", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the pong ^_^",
     * )
     * @SWG\Tag(name="test")
     */
    public function __invoke()
    {
        return new JsonResponse('pong');
    }
}