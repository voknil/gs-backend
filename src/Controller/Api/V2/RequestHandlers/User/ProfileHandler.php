<?php

namespace App\Controller\Api\V2\RequestHandlers\User;

use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Controller\Api\V2\Requests\User\UserRegistrationRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ProfileHandler
 * @package App\Controller\Api\V2\RequestHandlers\User
 * @Route("/api/v2/user/profile", name="post_api")
 */
class ProfileHandler extends BaseApiHandler
{

    /**
     * @param UserRepository $userRepository
     * @param $id
     * @Route("/{id}", name="profile", methods={"GET"})
     */
    public function getProfile(UserRepository $userRepository, $id){

       $currentUser = $userRepository->findOneBy(['id' => $id]);

        /**
         * test block
         */
       if(!$currentUser){
           $currentUser = new User();
           $currentUser->setEmail("test2@email.ru");
           $currentUser->setPassword(123456);
       }

        return new JsonResponse($currentUser->getEmail());
    }


    /**
     * @param UserRepository $userRepository
     * @Route("", name="profile_edit", methods={"POST"})
     */
    public function editProfile(Request $request, UserRepository $userRepository){
        $request = json_decode($request->getContent(), false);

        $currentUser = $userRepository->findOneBy(['email' => $request->email]);

        if(!$currentUser){
            $currentUser=new User();
            $currentUser->setEmail($request->email);
            $currentUser->setPassword($request->password);
        }

        //в UserRepository надо добавить метод update
        //$userRepository->update($currentUser);

        return new JsonResponse($currentUser->getEmail());
    }
}