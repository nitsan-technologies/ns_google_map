<?php

defined('TYPO3_MODE') || die('Access denied.');

if (version_compare(TYPO3_branch, '11.0', '>=')) {
    $moduleClass = \Nitsan\NsGoogleMap\Controller\AddressController::class;
} else {
    $moduleClass = 'Address';
}



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Nitsan.NsGoogleMap',
    'Map',
    [
        $moduleClass => 'list',
    ],
    // non-cacheable actions
    [
        $moduleClass => '',
    ]
);

/* set iconidentifier */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$typeArray = [
    'ext-google-map-icon',
];
foreach ($typeArray as $currentType) {
    $iconRegistry->registerIcon(
        $currentType,
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:ns_google_map/Resources/Public/Icons/' . $currentType . '.svg']
    );
}

if (version_compare(TYPO3_branch, '9.0', '>')) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1549261866] = [
        'nodeName' => 'MapUtility',
        'priority' => 70,
        'class' => \Nitsan\NsGoogleMap\Utility\MapUtility::class,
    ];
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['ns_google_map'] = \Nitsan\NsGoogleMap\Hooks\PageLayoutView::class;
