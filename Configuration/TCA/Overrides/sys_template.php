<?php
defined('TYPO3') or die();
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$extKey = 'ns_google_map';

ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', '[Nitsan] Google Map');
ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgooglemap_domain_model_address', 'EXT:ns_google_map/Resources/Private/Language/locallang_csh_tx_nsgooglemap_domain_model_address.xlf');
