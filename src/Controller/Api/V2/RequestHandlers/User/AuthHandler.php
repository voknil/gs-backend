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
use Swagger\Annotations as SWG;

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
     *
     * * @SWG\Parameter(
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
     *              	@SWG\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxfQ.ezxpfobjm1LSWpGA4UcVsPS3z4rM7HIbXK3XfEySzwM"),
     *     )
     *   )
     * @SWG\Response(
     *     response=400,
     *     description="User not found",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="result", type="string", example="false"),
     *         @SWG\Property(property="error", type="string", example="User not found"),
     *     )
     *   )
     * )
     * @SWG\Tag(name="user")
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