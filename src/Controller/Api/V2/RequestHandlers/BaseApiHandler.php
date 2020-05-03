<?php


namespace App\Controller\Api\V2\RequestHandlers;

use App\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class BaseApiHandler
 *
 * @package App\Controller\Api\V2\RequestHandlers
 */
class BaseApiHandler
{
    public function validateRequest(ConstraintViolationListInterface $validationErrors): void
    {
        if(count($validationErrors) > 0 ) {
            foreach ($validationErrors as $validationError) {
                $messages [] = $validationError->getConstraint()->message;
            }

            throw new ValidationException($messages ?? []);
        }
    }

}
