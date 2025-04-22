<?php

namespace Rfuehricht\FormhandlerAjax\Ajax;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
*                                                                        *
* TYPO3 is free software; you can redistribute it and/or modify it under *
* the terms of the GNU General Public License version 2 as published by  *
* the Free Software Foundation.                                          *
*                                                                        *
* This script is distributed in the hope that it will be useful, but     *
* WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
* TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
* Public License for more details.                                       *
*                                                                        */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rfuehricht\Formhandler\Utility\Globals;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A class removing uploaded files. This class is called via AJAX.
 *
 */
class RemoveFile
{

    /**
     * Main method of the class.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $fieldName = $params['field'] ?? null;
        $hash = $params['hash'] ?? null;
        $content = '';

        /** @var Globals $globals */
        $globals = GeneralUtility::makeInstance(Globals::class);
        $globals->setRandomId($params['token'] ?? '');

        if ($fieldName) {
            $sessionFiles = $globals->getSession()->get('files');

            if (is_array($sessionFiles) && isset($sessionFiles[$fieldName])) {
                foreach ($sessionFiles[$fieldName] as $index => $file) {
                    $filePath = $file['uploaded_path'] .
                        $file['uploaded_name'];

                    if (($hash !== null && $hash === $file['fileHash']) || $hash === null) {


                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        unset($sessionFiles[$fieldName][$index]);
                    }
                }
            }
            $globals->getSession()->set('files', $sessionFiles);
        }

        return new HtmlResponse($content);
    }


}
