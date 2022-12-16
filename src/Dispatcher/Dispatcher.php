<?php declare(strict_types=1);

namespace Surda\Zebra\Dispatcher;

use Surda\Zebra\Client\Client;
use Surda\Zebra\Client\CommunicationException;
use Surda\Zebra\Printer\IPrinter;
use Surda\Zebra\Label\ILabel;

class ZebraDispatcher
{
    /**
     * @throws DispatchException
     */
    public function dispatch(ILabel $label, IPrinter $printer): void
    {
        try {
            $client = new Client($printer->getHost(), $printer->getPort(), 5);
            $client->send($label->getData());
        } catch (CommunicationException $e) {
            throw new DispatchException($e->getMessage(), $e->getCode());
        }
    }
}
