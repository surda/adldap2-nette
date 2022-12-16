<?php declare(strict_types=1);

namespace Surda\Zebra\Printer;

class Printer implements IPrinter
{
    private string $name;
    private string $host;
    private int $port;

    public function __construct(string $name, string $host, int $port = 9100)
    {
        $this->name = $name;
        $this->host = $host;
        $this->port = $port;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }
}