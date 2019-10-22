<?php
namespace ADelf\PHPServer;

use ADelf\PHPServer\Exceptions\BindSocketException;
use ADelf\PHPServer\Exceptions\CallbackDontCallableException;

class Server
{
    protected $host;
    protected $port;
    protected $socket;


    /**
     * Server constructor.
     * @param string $host
     * @param int|string $port
     * @throws BindSocketException
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;

        $this->createSocket();
        $this->bindSocket();

        return $this;
    }

    /**
     * @param callable $callback
     * @throws CallbackDontCallableException
     */
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


    /**
     * @return void
     */
    protected function createSocket() : void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
    }

    /**
     * @return void
     * @throws BindSocketException
     */
    protected function bindSocket() : void
    {
        if (!socket_bind($this->socket, $this->host, $this->port)) {
            throw new BindSocketException($this->host, $this->port);
        }
    }
}