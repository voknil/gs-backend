<?php
declare(strict_types=1);

namespace App\Controller\Api\V2\RequestHandlers\User;

use App\Controller\Api\V2\RequestHandlers\BaseApiHandler;
use App\Enum\MailPriority;
use App\Exception\ValidationException;
use App\Helpers\RedisHelper;
use App\Helpers\UserHelper;
use App\Mails\ChangePasswordMail;
use App\Repository\UserRepository;
use App\Requests\User\PasswordRecoveryRequest;
use Doctrine\DBAL\Connection;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Swagger\Annotations as SWG;

/**
 * Class PasswordRecoveryHandler
 * @package App\Controller\Api\V2\RequestHandlers\User
 */
class PasswordRecoveryHandler extends BaseApiHandler
{
    /**
     * @var int
     */
    private const MIN_PASSWORD_LENGTH = 10;

    /**
     * @Route("/api/v2/user/password/recovery", methods={"POST"})
     *
     * @ParamConverter("request", converter="fos_rest.request_body")
     *
     * @param PasswordRecoveryRequest $request
     * @param ConstraintViolationListInterface $validationErrors
     * @param UserRepository $userRepository
     * @param Connection $connection
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     *
     * @SWG\Tag(name="user")
     *
     * @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      description="JSON Payload",
     *      required=true,
     *      @SWG\Schema(
     *           type="object",
     *           @SWG\Property(property="email", type="string", example="email@email.com"),
     *      )
     *  ),
     * @SWG\Response(
     *     response=200,
     *     description="Always return success",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="result", type="string", example="true"),
     *     )
     *   )
     */
    public function __invoke(
        PasswordRecoveryRequest $request,
        ConstraintViolationListInterface $validationErrors,
        UserRepository $userRepository,
        Connection $connection
    ){
       $this->validateRequest($validationErrors);
       $currentUser = $userRepository->findOneBy(['email' => $request->getEmail()]);

       if(!$currentUser) {
           return new JsonResponse(['result' => true], Response::HTTP_OK);
       }

       $password = UserHelper::generateNewPassword(self::MIN_PASSWORD_LENGTH);

       $connection->beginTransaction();

       try {
           $userRepository->recoveryPassword($currentUser, $password);

           $mail = new ChangePasswordMail();
           $mail->setTo($currentUser->getEmail());
           $mail->setNewPassword($password);

           $serializedMail = serialize($mail);

           $redis = RedisHelper::getConnection();
           $redisKey = RedisHelper::crateMailKey(MailPriority::HIGH);

           $redis->set($redisKey, $serializedMail);
           $connection->commit();

           return new JsonResponse(['result' => true], Response::HTTP_OK);
       } catch (Exception $exception) {
           $connection->rollBack();
           throw new Exception($exception->getMessage());
       }
    }
}