<?php

namespace Rfuehricht\FormhandlerAjax\ViewHelpers;

use Rfuehricht\Formhandler\Utility\Globals;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class FileRemoveButtonViewHelper extends AbstractViewHelper
{

    protected $escapeOutput = false;
    protected $escapeChildren = false;
    private Globals $globals;

    public function injectGlobals(Globals $globals): void
    {
        $this->globals = $globals;
    }

    public function render(): string
    {
        $fileInfo = $this->arguments['file'];
        $textContent = trim($this->arguments['value'] ?? $this->renderChildren());
        $url = '/?eID=formhandler-remove-file';
        $url .= '&field=' . $fileInfo['field'];
        $url .= '&filehash=' . $fileInfo['fileHash'];
        $url .= '&token=' . $this->globals->getRandomId();
        return '<button
                    data-formhandler-action="file-remove"
                    data-hx-get="' . $url . '"
                    data-hx-target="this"
                    data-hx-swap="outerHTML">' . $textContent . '

                 </button>';

    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'file',
            'array',
            'Formhandler file info',
            true
        );
        $this->registerArgument(
            'value',
            'string',
            'Text content of the button'
        );
    }
}
