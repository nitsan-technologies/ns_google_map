<?php
defined('TYPO3_MODE') or die();

$extKey = 'ns_google_map';

$fields = [
    'map' => [
        'exclude' => true,
        'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.map',
        'config' => [
            'type' => 'user',
            'userFunc' => \Nitsan\NsGoogleMap\Utility\MapUtility::class . '->render',
            'renderType' => 'MapUtility',
            'parameters' => [
                'longitude' => 'longitude',
                'latitude' => 'latitude',
                'address' => 'address',
            ],
        ],
    ],
];
if (version_compare(TYPO3_branch, '9.0', '>')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_nsgooglemap_domain_model_address', $fields);
}
// register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Nitsan.NsGoogleMap',
    'Map',
    'Google Map'
);

// Flexform
$pluginSignature = str_replace('_', '', $extKey) . '_map';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extKey . '/Configuration/FlexForms/FlexForm.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';
