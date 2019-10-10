<?php
namespace Src\Exceptions;
use Throwable;

class WrongCredentialsException extends \Exception
{
    public function __construct(string $message = "", int $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}