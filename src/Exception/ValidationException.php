<?php


namespace App\Exception;

use Exception;
use Throwable;


/**
 * Class ValidationException
 *
 * @package App\Exception
 */
class ValidationException extends Exception
{
    /**
     * @var array
     */
    private $messages;

    /**
     * ValidationException constructor.
     *
     * @param array          $validationErrors
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(array $validationErrors,$message = "", $code = 0, Throwable $previous = null)
    {
        $this->messages = $validationErrors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->messages;
    }
}