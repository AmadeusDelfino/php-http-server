<?php


namespace ADelf\PHPServer\Exceptions;


class CallbackDontCallableException extends \Exception
{
    protected $message = 'The given argument should be callable.';
}