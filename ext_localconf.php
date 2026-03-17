<?php

defined('TYPO3') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsGoogleMap',
    'Map',
    [
        \Nitsan\NsGoogleMap\Controller\AddressController::class => 'list',
    ],
    // non-cacheable actions
    [
        \Nitsan\NsGoogleMap\Controller\AddressController::class => '',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1549261866] = [
    'nodeName' => 'MapUtility',
    'priority' => 70,
    'class' => \Nitsan\NsGoogleMap\Utility\MapUtility::class,
];
