<?php

namespace SON\View;

class ViewRenderer
{
    private $pathTemplates;
    private $templateName;

    public function __construct($pathTemplates)
    {
        $this->pathTemplates = $pathTemplates;
    }

    public function render($name, array $data = [])
    {
        $content = $this->getOutPut($name, $data);
        $layout = __DIR__ . '/../../templates/layouts/layout.phtml';
        return $this->getOutPut($layout, ['content' => $content]);
    }

    protected function getOutPut($name, array $data = [], $template = null)
    {
        $this->templateName = $name;
        extract($data);
        ob_start();
        if (!file_exists($this->templateName)) {
            include $this->pathTemplates . $this->templateName . '.phtml';
        } else {
            include $this->templateName;
        }
        $output = ob_get_clean();
        return $output;
    }
}