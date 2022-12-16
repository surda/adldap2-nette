<?php declare(strict_types=1);

namespace Surda\Zebra\Label;

class DummyDataLabel implements ILabel
{
    private string $zpl =
"
^XA
^MMT
^PW406
^LL0203
^LS0
^FT20,47^A0N,23,24^FH\^FD TONER CARTRIDGE HP CE505X^FS
^FT20,86^A0N,23,24^FH\^FDPLU :^FS
^FT81,86^A0N,23,24^FH\^FDo4000444^FS
^BY2,3,51^FT20,149^B3N,N,,N,N
^FDo4000333^FS
^FT20,180^A0N,23,24^FH\^FDCena:^FS
^FT89,180^A0N,23,24^FH\^FD499,-Kc^FS
^FT250,180^A0N,23,24^FH\^FD0208^FS
^PQ1,0,1,Y
^XZ
";

    public function getData(): string
    {
        return $this->zpl;
    }
}