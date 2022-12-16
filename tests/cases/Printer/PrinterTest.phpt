<?php declare(strict_types=1);

namespace Tests\Surda\Zebra\Printer;

use Surda\Zebra\Printer\Printer;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class PrinterTest extends TestCase
{
    public function testPrinter()
    {
        $printer = new Printer('foo', 'bar', 9100);

        Assert::same('foo', $printer->getName());
        Assert::same('bar', $printer->getHost());
        Assert::same(9100, $printer->getPort());
    }
}

(new PrinterTest())->run();