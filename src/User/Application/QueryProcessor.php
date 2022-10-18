<?php

declare(strict_types=1);

namespace App\User\Application;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class QueryProcessor
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer=$serializer;
    }

    public function getProfile($user):JsonResponse{

        if(!$user){
            return new JsonResponse('User not found!', 404);
        }

        return new JsonResponse($this->serializer->serialize($user, 'json'), 200);
    }
}