<?php declare(strict_types=1);

namespace Surda\Zebra\Renderer;

use Latte\Engine;
use Surda\Zebra\Template\ITemplate;

interface IRenderer
{
    public function getLatte(): Engine;

    public function render(ITemplate $template): string;
}