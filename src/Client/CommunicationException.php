<?php declare(strict_types=1);

namespace Surda\Zebra\Client;

use RuntimeException;

class CommunicationException extends \ErrorException
{
    public static function createFromPhpError(): self
    {
        $error = error_get_last();
        return new self($error['message'] ?? 'An error occured', 0, $error['type'] ?? 1);
    }
}