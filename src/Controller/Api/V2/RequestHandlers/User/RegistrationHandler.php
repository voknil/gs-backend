<?php


namespace App\Controller\Api\V2\RequestHandlers\User;


use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Controller\Api\V2\Requests\User\UserRegistrationRequest;
use App\Exception\User\UserAlreadyExistsException;
use App\Exception\ValidationException;
use App\Helpers\JwtHelper;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class RegistrationHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers\User
 */
class RegistrationHandler extends BaseApiHandler
{
    /**
     * @Route("/api/v2/user/register")
     * @ParamConverter("request", converter="fos_rest.request_body")
     *
     * @param UserRegistrationRequest          $request
     * @param ConstraintViolationListInterface $validationErrors
     *
     * @param UserRepository                   $userRepository
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws UserAlreadyExistsException
     */
    public function __invoke(UserRegistrationRequest $request,
                             ConstraintViolationListInterface $validationErrors,
                             UserRepository $userRepository
    ) {
        $this->validateRequest($validationErrors);

        $user = $userRepository->register($request);

        $token = JwtHelper::createToken($user->getId());

        return new JsonResponse(['access_token' => $token], Response::HTTP_CREATED);
    }
}