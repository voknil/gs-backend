<?php


namespace App\Controller\Api\V2\RequestHandlers\User;


use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Exception\User\PasswordIncorrectException;
use App\Exception\User\UserNotFoundException;
use App\Exception\ValidationException;
use App\Helpers\JwtHelper;
use App\Repository\UserRepository;
use App\Requests\User\AuthRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AuthHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers\User
 */
class AuthHandler extends BaseApiHandler
{
    /**
     * @Route("/api/v2/user/auth", methods={"POST"})
     * @ParamConverter("request", converter="fos_rest.request_body")
     *
     * @param AuthRequest                      $request
     * @param ConstraintViolationListInterface $validationErrors
     * @param UserRepository                   $userRepository
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws UserNotFoundException
     * @throws PasswordIncorrectException
     */
    public function __invoke(
        AuthRequest $request,
        ConstraintViolationListInterface $validationErrors,
        UserRepository $userRepository
    ): JsonResponse {
       $this->validateRequest($validationErrors);
       $user = $userRepository->auth($request);

       $accessToken = JwtHelper::createToken($user->getId());

       return new JsonResponse(['accessToken' => $accessToken]);
    }
}