# [Zebra2](https://github.com/Zebra2/Zebra2) integration into Nette Framework.

[![Licence](https://img.shields.io/packagist/l/surda/zebra.svg?style=flat-square)](https://packagist.org/packages/surda/zebra)
[![Latest stable](https://img.shields.io/packagist/v/surda/zebra.svg?style=flat-square)](https://packagist.org/packages/surda/zebra)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Installation

The recommended way to is via Composer:

```
composer require surda/zebra
```
### Basic using

```php
$client = new \Surda\Zebra\Client\Client(host: '192.168.0.100');
$client->send(zpl: '^XA.......^XZ');
```

### Using dispatcher

```php
$label = new \Surda\Zebra\Label\DummyDataLabel();
$printer = new \Surda\Zebra\Printer\Printer(name: 'name', host: '192.168.0.100');
$dispatcher = new \Surda\Zebra\Dispatcher\ZebraDispatcher();
$dispatcher->dispatch(label: $label, printer: $printer);
```

### Nette Latte template

OrderLabel.latte
```latte
^XA
^MMT
^PW400
^LL0200
^LS0
^BY2,3,51^FT20,80^B3N,N,,N,N^FD{$order->getNumber()}^FS
^FT260,75^A0N,50,50^FH\^FD{$order->getNumber()}^FS
^PQ{$quantity},0,1,Y
^XZ
```

OrderLabel.php

```php
class OrderLabel implements \Surda\Zebra\Label\ILabel
{
    public function __construct(private Order $order)
    {
    }

    public function getData(): string
    {
        $template = new \Surda\Zebra\Template\Template(
            __DIR__ . '/OrderLabel.latte',
            [
                'order' => $this->order,
                'quantity' => 1,
            ]
        );
        return (new \Surda\Zebra\Label\TemplateLabel($template))->getData();
    }
}
```

OrderLabelFactory.php

```php
interface OrderLabelFactory
{
    public function create(Order $order)): OrderLabel;
}
```

LabelPrintManager.php

```php
class LabelPrintManager
{
    public function __construct(
        private \Surda\Zebra\Printer\IPrinter $printer, 
        private \Surda\Zebra\Dispatcher\ZebraDispatcher $dispatcher,
    )
    {
    }

    public function print(ILabel $label): void
    {
        try {
            $this->dispatcher->dispatch($label, $this->printer);
        } catch (DispatchException) {
            throw new \Surda\Zebra\PrintException();
        }
    }
}
```

config.neon

```neon
service:
    zebraPrinter:
        factory: \Surda\Zebra\Printer\Printer('name', '192.168.0.100', 9100)
        autowired: false
    - OrderLabelFactory
    - LabelPrintManager(@zebraPrinter)
```

Presenter

```php
#[Inject]
public OrderLabelFactory $orderLabelFactory;

#[Inject]
public LabelPrintManager $labelPrintManager;

public function print() {
    $order = new Order();
    $label = $this->orderLabelFactory->create($order);
    $this->labelPrintManager->print($label);
}
```
