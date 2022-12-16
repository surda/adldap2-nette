<?php declare(strict_types=1);

namespace Surda\Zebra\Client;

use Socket;

class Client
{
    protected Socket $socket;

    public function __construct(string $host, int $port = 9100, int $timeout = 60)
    {
        $this->connect($host, $port, $timeout);
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * @throws CommunicationException
     */
    protected function connect(string $host, int $port, int $timeout): void
    {
        error_clear_last();
        $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($socket === false) {
            throw CommunicationException::createFromPhpError();
        }

        if ($timeout !== 60) {
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]);
            socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $timeout, 'usec' => 0]);
        }

        if (@socket_connect($socket, $host, $port) === false) {
            throw CommunicationException::createFromPhpError();
        }

        $this->socket = $socket;
    }

    protected function disconnect(): void
    {
        @socket_close($this->socket);
    }

    /**
     * @throws CommunicationException
     */
    public function send(string $zpl): void
    {
        if (false === @socket_write($this->socket, $zpl)) {
            throw CommunicationException::createFromPhpError();
        }
    }
}
