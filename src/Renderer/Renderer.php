<?php declare(strict_types=1);

namespace Surda\Zebra\Renderer;

use Latte\Engine;
use Nette\Utils\Strings;
use Surda\Zebra\Template\ITemplate;

class Renderer implements IRenderer
{
    private Engine $latte;

    public function __construct()
    {
        $this->latte = new Engine();
        $this->latte->addFilter('webalize', function ($s, $charlist = NULL, $lower = TRUE) {
            return Strings::webalize($s, $charlist, $lower);
        });
    }

    public function getLatte(): Engine
    {
        return $this->latte;
    }

    public function render(ITemplate $template): string
    {
        return $this->latte->renderToString($template->getTemplateName(), $template->getTemplateVariables());
    }
}