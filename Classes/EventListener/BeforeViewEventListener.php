<?php

declare(strict_types=1);

namespace Rfuehricht\FormhandlerAjax\EventListener;

use Rfuehricht\Formhandler\Event\BeforeViewEvent;
use Rfuehricht\Formhandler\Utility\Globals;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsEventListener(
    identifier: 'formhandler-ajax/before-view',
)]
final readonly class BeforeViewEventListener
{

    public function __construct(
        private readonly Globals $globals
    )
    {
    }

    public function __invoke(BeforeViewEvent $event): void
    {
        $settings = $this->globals->getSettings();
        $validations = $this->globals->getValidations();
        GeneralUtility::makeInstance(AssetCollector::class)
            ->addJavaScript(
                'formhandler-ajax-htmx',
                'EXT:formhandler_ajax/Resources/Public/JavaScript/htmx.min.js'
            )
            ->addJavaScript(
                'formhandler',
                'EXT:formhandler_ajax/Resources/Public/JavaScript/formhandler.js'
            );

        $inlineSettings = [
            'formValuesPrefix' => $this->globals->getFormValuesPrefix(),
            'validations' => $validations
        ];
        if (isset($settings['ajaxSubmit']) && boolval($settings['ajaxSubmit']) === true) {
            $inlineSettings['ajaxSubmit'] = true;
        }

        $finalSettings = [
            $this->globals->getRandomId() => $inlineSettings
        ];
        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addInlineSettingArray('formhandler', $finalSettings);
    }
}
