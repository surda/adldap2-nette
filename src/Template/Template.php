<?php declare(strict_types=1);

namespace Surda\Zebra\Template;

class Template implements ITemplate
{
    private string $templateName;

    /** @var array<int|string, string> */
    private array $templateVariables;

    /**
     * @param array<int|string, string> $templateVariables
     */
    public function __construct(string $templateName, array $templateVariables = [])
    {
        $this->templateName = $templateName;
        $this->templateVariables = $templateVariables;
    }

    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @return array<int|string, string>
     */
    public function getTemplateVariables(): array
    {
        return $this->templateVariables;
    }
}