<?php
defined('TYPO3_MODE') or die();

$extKey = 'ns_google_map';
if(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version(TYPO3_branch) <= 8.0){
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript/OlderVersion', '[Nitsan] Google Map');
} else {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', '[Nitsan] Google Map');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nsgooglemap_domain_model_address', 'EXT:ns_google_map/Resources/Private/Language/locallang_csh_tx_nsgooglemap_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nsgooglemap_domain_model_address');
