<?php declare(strict_types=1);

namespace Surda\Zebra\Printer;

interface IPrinter
{
    public function getName(): string;

    public function getHost(): string;

    public function getPort(): int;
}