<?php

namespace App\Controller\Api\V2\RequestHandlers\User;

use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Controller\Api\V2\Requests\User\UserRegistrationRequest;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     *
     */
    public function getProfile(UserRepository $userRepository, $id){

        $currentUser = $userRepository->findOneBy(['id' => $id]);

        if(!$currentUser) {
            return new JsonResponse([['error' => 'User is not found!'],],Response::HTTP_NOT_FOUND);
        }

        $data=[
          'user'=>[
              'id'=>$currentUser->getId(),
              'email'=>$currentUser->getEmail(),
              'name'=>$currentUser->getName(),
              'surname'=>$currentUser->getSurname(),
              'birthday'=>$currentUser->getBirthday(),
              'gender'=>$currentUser->getGender(),
              'location'=>$currentUser->getLocation()
          ]
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @Route("", name="profile_edit", methods={"PUT"})
     */
    public function editProfile(Request $request, UserRepository $userRepository){
        $request = json_decode($request->getContent(), false);

        $userFromDB = $userRepository->findOneBy(['email' => $request->email]);

        if(!$userFromDB){
            return new JsonResponse([['error' => 'User is not found!'],],Response::HTTP_NOT_FOUND);
        }

        $userRepository->update($userFromDB, $request);

        return new JsonResponse($userFromDB->getName());
    }



}