<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    // Module System > Wordpress Importer
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'TYPO3.CMS.wpimport',
        'system',
        'wpimport',
        'top',
        array(
            'Import' => 'index'
        ),
        array(
            'access' => 'admin',
            'icon' => 'EXT:wpimport/Resources/Public/Icons/module-wpimport.png',
            'labels' => 'LLL:EXT:wpimport/Resources/Private/Language/locallang_mod.xlf'
        )
    );
}
