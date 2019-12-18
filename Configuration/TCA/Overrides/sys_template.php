<?php
defined('TYPO3_MODE') or die();

$extKey = 'ns_google_map';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', '[Nitsan] Google Map');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgooglemap_domain_model_address', 'EXT:ns_google_map/Resources/Private/Language/locallang_csh_tx_nsgooglemap_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgooglemap_domain_model_address');
