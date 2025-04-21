<?php

defined('TYPO3') or die();


$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler-remove-file'] = RemoveFile::class . '::process';
