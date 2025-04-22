<?php

namespace Rfuehricht\FormhandlerAjax\ViewHelpers;


use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class FormViewHelper extends \Rfuehricht\Formhandler\ViewHelpers\FormViewHelper
{


    public function render(): string
    {
        $this->setFormActionUri();
        $attributeName = 'hx-post';
        if (strtolower($this->tag->getAttribute('method') ?? '') === 'get') {
            $attributeName = 'hx-get';
        }
        $this->tag->addAttribute($attributeName, $this->tag->getAttribute('action') ?? '', false);

        /** @var ContentObjectRenderer $contentObjectRenderer */
        $contentObjectRenderer = $this->getRequest()?->getAttribute('currentContentObject');
        if ($contentObjectRenderer) {
            $elementId = $contentObjectRenderer->data['uid'];
            $this->tag->addAttribute('hx-target', '#c' . $elementId);
            $this->tag->addAttribute('hx-select', '#c' . $elementId);
            $this->tag->addAttribute('hx-swap', 'outerHTML');
        }

        return parent::render();
    }

    private function getRequest(): ServerRequestInterface|null
    {
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            return $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }
        return null;
    }
}
