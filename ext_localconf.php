<?php

defined('TYPO3') || die('Access denied.');

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NsGoogleMap',
    'Map',
    [
        \Nitsan\NsGoogleMap\Controller\AddressController::class => 'list',
    ],
    // non-cacheable actions
    [
        \Nitsan\NsGoogleMap\Controller\AddressController::class => '',
    ]
);

/* set iconidentifier */
$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);

$iconRegistry->registerIcon(
    'ext-google-map-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:ns_google_map/Resources/Public/Icons/ext-google-map-icon.svg']
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1549261866] = [
    'nodeName' => 'MapUtility',
    'priority' => 70,
    'class' => \Nitsan\NsGoogleMap\Utility\MapUtility::class,
];

