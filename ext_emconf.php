<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Wordpress Importer',
    'description' => 'A Wordpress Importer for TYPO3',
    'category' => 'be',
    'version' => '8.1.0',
    'state' => 'stable',
    'uploadfolder' => false,
    'createDirs' => null,
    'clearcacheonload' => true,
    'author' => 'Frank Nägler',
    'author_email' => 'frank.naegler@typo3.org',
    'author_company' => '',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.1.0-8.1.99',
            'backend' => '8.1.0'
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
);
