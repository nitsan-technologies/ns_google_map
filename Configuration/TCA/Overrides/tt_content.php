<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
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

ExtensionManagementUtility::addTCAcolumns('tx_nsgooglemap_domain_model_address', $fields);
// register plugin
$pluginSignature = ExtensionUtility::registerPlugin(
    'NsGoogleMap',
    'Map',
    'Google Map'
);

// Flexform
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extKey . '/Configuration/FlexForms/FlexForm.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key';
