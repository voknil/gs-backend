<?php

namespace App\Controller;

use App\Entity\User;
use App\Helpers\UserHelper;
use http\Env\Response;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

#[Route(path: "/api/v1/user", name: "user_")]
class UserController extends AbstractController
{
    private $userRepo;

    public function __construct(UserRepository $userRepo,)
    {
        $this->userRepo=$userRepo;
    }


    #[Route('/{id}', name: 'profile', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the user profile'
    )]
    public function getUserProfile(int $id): JsonResponse
    {
        $user = $this->userRepo->find($id);
        if(!$user){
          return $this->json(['Message'=>"User not found"], 404);
        }

        return $this->json(UserHelper::UserToJson($user));
    }
}
