<?php declare(strict_types=1);

namespace Surda\Zebra\Label;

use Surda\Zebra\Template\ITemplate;
use Surda\Zebra\Renderer\IRenderer;
use Surda\Zebra\Renderer\Renderer;

class TemplateLabel implements ILabel
{
    private ITemplate $template;
    private IRenderer $renderer;

    public function __construct(ITemplate $template, ?IRenderer $renderer = NULL)
    {
        $this->template = $template;
        $this->renderer = $renderer === NULL ? new Renderer() : $renderer;
    }

    public function getData(): string
    {
        return $this->getRenderer()->render($this->template);
    }

    private function getRenderer(): IRenderer
    {
        return $this->renderer;
    }
}