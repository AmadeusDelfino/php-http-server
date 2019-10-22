<?php
namespace ADelf\PHPServer;

use ADelf\PHPServer\Exceptions\BindSocketException;
use ADelf\PHPServer\Exceptions\CallbackDontCallableException;

class Server
{
    protected $host;
    protected $port;
    protected $socket;


    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;

        $this->createSocket();
        $this->bindSocket();

        return $this;
    }

    public function listen($callback)
    {
        if(!is_callable($callback)) {
            throw new CallbackDontCallableException();
        }

        while (true) {
            socket_listen($this->socket);
            if(!$client = socket_accept($this->socket)){
                socket_close($client);
                continue;
            }
        }
    }

    protected function createSocket() : void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
    }

    protected function bindSocket() : void
    {
        if (!socket_bind($this->socket, $this->host, $this->port)) {
            throw new BindSocketException($this->host, $this->port);
        }
    }
}