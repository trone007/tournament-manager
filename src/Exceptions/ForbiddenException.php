<?php
namespace Src\Exceptions;
use Throwable;

class ForbiddenException extends \Exception
{
    public function __construct(string $message = "", int $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        header('Location: /403');
        die();
    }
}