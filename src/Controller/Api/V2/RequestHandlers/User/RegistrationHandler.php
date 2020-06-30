<?php


namespace App\Controller\Api\V2\RequestHandlers\User;


use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Requests\User\UserRegistrationRequest;
use App\Exception\User\UserAlreadyExistsException;
use App\Exception\ValidationException;
use App\Helpers\JwtHelper;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Swagger\Annotations as SWG;

/**
 * Class RegistrationHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers\User
 */
class RegistrationHandler extends BaseApiHandler
{
    /**
     * @Route("/api/v2/user/register", methods={"POST"})

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
     *
     * @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="email", type="string", example="email@email.com"),
     *              @SWG\Property(property="password", type="string", example="qwerty12345"),
     *          )
     *      ),
     * @SWG\Response(
     *     response=200,
     *     description="Returns the access JWT token",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.ezxpfobjm1LSWpGA4UcVsPS3z4rM7HIbXK3XfEySzwM"),
     *     )
     *   )
     * @SWG\Response(
     *     response=400,
     *     description="User already exists",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="result", type="string", example="false"),
     *         @SWG\Property(property="error", type="string", example="User with this email already exists"),
     *     )
     *   )
     * )
     * @SWG\Tag(name="user")
     */
    public function __invoke(UserRegistrationRequest $request,
                             ConstraintViolationListInterface $validationErrors,
                             UserRepository $userRepository
    ): JsonResponse {
        $this->validateRequest($validationErrors);

        $user = $userRepository->register($request);

        $token = JwtHelper::createToken($user->getId());

        return new JsonResponse(['access_token' => $token], Response::HTTP_CREATED);
    }
}