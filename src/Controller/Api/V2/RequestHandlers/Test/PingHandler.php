<?php


namespace App\Controller\Api\V2\RequestHandlers\Test;


use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

/**
 * Class PingHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers\Test
 */
class PingHandler extends BaseApiHandler
{
    /**
     * @Route("/api/v2/ping", name="health_check")
     */
    public function __invoke()
    {
       return new JsonResponse('pong');
    }
}