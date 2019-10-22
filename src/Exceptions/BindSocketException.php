<?php


namespace ADelf\PHPServer\Exceptions;


use Throwable;

class BindSocketException extends \Exception
{
    public function __construct($host, $port)
    {
        $message = 'Cannot bind: ' . $host . ':' . $port . ' - ' . socket_strerror(socket_last_error());
        parent::__construct($message, 500, null);
    }
}