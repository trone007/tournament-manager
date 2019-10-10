<?php
namespace Src\Exceptions;
use Throwable;

class WrongParametersException extends \Exception
{
    public function __construct(string $message = "", int $code = 402, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}