<?php

/// in bootstrap

$paths = new \kalanis\kw_paths\Path();
$paths->setDocumentRoot(realpath($_SERVER['DOCUMENT_ROOT']));
$paths->setPathToSystemRoot('/..');

/// ... other steps

// init styles
\kalanis\kw_styles\Styles::init($paths);


//// Now class itself

use kalanis\kw_mime\MimeType;
use kalanis\kw_extras\ExternalLink;
use kalanis\kw_styles\Styles as ExStyles;


/**
 * Class Styles
 * Render styles in page
 * Also can load and flush the whole wanted style sheet
 */
class Styles
{
    /** @var MimeType */
    protected $mime = null;
    /** @var StylesTemplate */
    protected $template = null;
    /** @var ExternalLink */
    protected $libExtLink = '';
    /** @var string[] */
    protected $params = [];

    public function __construct($params = [])
    {
        $this->mime = new MimeType(true);
        $this->template = new StylesTemplate();
        $this->libExtLink = new ExternalLink();
        $this->params = $params;
    }

    public function flushLayout(): string
    {
        $content = [];
        foreach (ExStyles::getAll() as $module => $scripts) {
            foreach ($scripts as $script) {
                $content[] = $this->template->reset()->setData(
                    $this->libExtLink->linkVariant($module . '/' . $script, 'styles', true, false)
                )->render();
            }
        }
        return implode('', $content);
    }

    public function flushContent(): string
    {
        try {
            $content = ExStyles::getFile($this->params['module'], $this->params['path']);
            if ($content) {
                header("Content-Type: " . $this->mime->mimeByPath('any.css'));
            }
            return $content;
        } catch (\kalanis\kw_styles\StylesException $ex) {
            return '';
        }
    }
}


/**
 * Class StylesTemplate
 */
class StylesTemplate extends ATemplate
{
    protected $moduleName = 'Styles';
    protected $templateName = 'template';

    protected function fillInputs(): void
    {
        $this->addInput('{STYLE_PATH}');
    }

    public function setData(string $path): self
    {
        $this->updateItem('{STYLE_PATH}', $path);
        return $this;
    }
}
