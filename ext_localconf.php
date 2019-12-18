<?php

use Nitsan\NsGoogleMap\Hooks\PageLayoutView;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Nitsan.NsGoogleMap',
    'Map',
    [
        'Address' => 'list'
    ],
    // non-cacheable actions
    [
        'Address' => ''
    ]
);

/* set iconidentifier */
$iconRegistry = GeneralUtility::makeInstance(
    IconRegistry::class
);
$typeArray = [
    'ext-google-map-icon'
];
foreach ($typeArray as $currentType) {
    $iconRegistry->registerIcon(
        $currentType,
        BitmapIconProvider::class,
        ['source' => 'EXT:ns_google_map/Resources/Public/Icons/' . $currentType . '.svg']
    );
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['ns_google_map'] = PageLayoutView::class;

    