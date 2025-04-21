<?php

$EM_CONF['formhandler'] = [
    'title' => 'Formhandler Ajax',
    'description' => 'Add AJAX capability to Formhandler. File upload, validation, submit.',
    'category' => 'frontend',
    'version' => '13.0.0',
    'state' => 'stable',
    'author' => 'Reinhard Führicht',
    'author_email' => 'r.fuehricht@gmail.com',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.99.99',
            'formhandler' => '13.0.0-13.99.99'
        ],
        'conflicts' => [
        ],
    ],
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1
];
