<?php

declare (strict_types=1);

namespace Nitsan\NsGoogleMap\Utility;

/***************************************************************
 *  Copyright notice
 *
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Google map.
 *
 */
class MapUtility extends AbstractFormElement
{
    public function render():array
    {
        $pluginSettings = [];
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $config = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $out = $this->initializeResultArray();
        if (isset($config['plugin.']) && array_key_exists('tx_nsgooglemap_map.', $config['plugin.'])) {
            $pluginSettings = $config['plugin.']['tx_nsgooglemap_map.']['settings.'];
        }
        if (!is_array($pluginSettings) || $pluginSettings === []) {
            $pluginSettings = $this->getPluginSettingsFromSiteSettings();
        }

        if (empty($pluginSettings['apiKey'])) {
            $versionNumber = VersionNumberUtility::convertVersionStringToArray(VersionNumberUtility::getCurrentTypo3Version());
            $message = $versionNumber['version_main'] >= 14
                ? 'Please configure the Google Map extension in Site Settings.'
                : 'Please configure the Google Map extension in TypoScript or  Site Settings.';

            $severity = $versionNumber['version_main'] >= 13
                ? ContextualFeedbackSeverity::WARNING
                : FlashMessage::WARNING;

            $flashMessage = GeneralUtility::makeInstance(
                FlashMessage::class,
                $message,
                'Google Map configuration missing',
                $severity,
                true
            );

            $flashMessageQueue = GeneralUtility::makeInstance(FlashMessageService::class)
                ->getMessageQueueByIdentifier('core.template.flashMessages');
            $flashMessageQueue->enqueue($flashMessage);

            $out['html'] = '';
            return $out;
        }
        $checkURL = GeneralUtility::getIndpEnv('TYPO3_SSL') ? 'https://' : 'http://';

        if ($checkURL == 'http://') {
            $googleMapsLibrary = 'http://maps.googleapis.com/maps/api/js?libraries=places';
        } else {
            $googleMapsLibrary = 'https://maps.googleapis.com/maps/api/js?libraries=places';
        }

        $pageRenderer->addJsFile('EXT:ns_google_map/Resources/Public/Js/jquery.min.js');
        $pageRenderer->addJsFile('EXT:ns_google_map/Resources/Public/Js/googleMap.js');

        if (isset($pluginSettings['apiKey'])) {
            $googleMapsLibrary .= '&key=' . $pluginSettings['apiKey'];
        }
        $latitude = (float) $this->data['databaseRow']['latitude'];
        $longitude = (float) $this->data['databaseRow']['longitude'];
        $address = $this->data['databaseRow']['address'];

        $baseElementId = isset($this->data['databaseRow']['itemFormElID']) ? $this->data['databaseRow']['itemFormElID'] : $this->data['tableName'] . '_' . $this->data['databaseRow']['uid'] . '_map';
        $addressId = 'data_' . $baseElementId . '_address';
        $mapId = $baseElementId . '_map';

        if (!($latitude && $longitude)) {
            $latitude = 0;
            $longitude = 0;
        }
        $dataPrefix = 'data[' . $this->data['tableName'] . '][' . $this->data['databaseRow']['uid'] . ']';
        $latitudeField = $dataPrefix . '[latitude]';
        $longitudeField = $dataPrefix . '[longitude]';
        $addressField = $dataPrefix . '[address]';

        $updateLatitudeJs = $this->updateField($this->data['tableName'], (string)$this->data['databaseRow']['uid'], $latitudeField, $this->data['databaseRow']['latitude']);
        $updateLongitudeJs = $this->updateField($this->data['tableName'], (string)$this->data['databaseRow']['uid'], $latitudeField, $this->data['databaseRow']['longitude']);
        $updateAddressJs = $this->updateField($this->data['tableName'], (string)$this->data['databaseRow']['uid'], $latitudeField, $this->data['databaseRow']['address']);

        $basePath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
        $out['html'] = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
        $out['html'] .= '<script src="' . $googleMapsLibrary . '"></script>';
        $out['html'] .= '<input type="hidden" value="' . $latitude . '" class="latitude"/>';
        $out['html'] .= '<input type="hidden" value="' . $longitude . '" class="longitude"/>';
        $out['html'] .= '<input type="hidden" value="' . $mapId . '" class="mapId"/>';
        $out['html'] .= '<input type="hidden" value="' . $addressId . '" class="addressId"/>';
        $out['html'] .= '<input type="hidden" value="' . $latitudeField . '" class="latitudeField"/>';
        $out['html'] .= '<input type="hidden" value="' . $longitudeField . '" class="longitudeField"/>';
        $out['html'] .= '<input type="hidden" value="' . $addressField . '" class="addressField"/>';
        $out['html'] .= '<input type="hidden" value="' . $updateLatitudeJs . '" class="updateLatitudeJs"/>';
        $out['html'] .= '<input type="hidden" value="' . $updateLongitudeJs . '" class="updateLongitudeJs"/>';
        $out['html'] .= '<input type="hidden" value="' . $updateAddressJs . '" class="updateAddressJs"/>';
        $out['html'] .= '<div id="' . $baseElementId . '">';
        $out['html'] .= '<input id="' . $addressId . '" type="textbox" value="' . $address . '" class="origin"  style="width:300px">';
        $out['html'] .= '<input type="button" id="findMap" value="Update">';
        $out['html'] .= '<div id="' . $mapId . '" style="height:400px;margin:10px 0;width:400px"></div>';
        $out['html'] .= '</div>'; // id=$baseElementId

        return $out;
    }

    /**
     * In backend form context, full TypoScript plugin settings can be empty.
     *
     * @return array<string, mixed>
     */
    protected function getPluginSettingsFromSiteSettings(): array
    {
        $pid = $this->data['databaseRow']['pid'] ?? 0;
        if (is_array($pid)) {
            $pid = (int)($pid[0] ?? 0);
        } else {
            $pid = (int)$pid;
        }

        if ($pid <= 0) {
            return [];
        }

        try {
            $site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pid);
            $siteSettings = $site->getSettings()->getAllFlat();
        } catch (\Throwable $exception) {
            return [];
        }

        return [
            'apiKey' => (string)($siteSettings['nsGoogleMap.settings.apiKey'] ?? ''),
            'language' => (string)($siteSettings['nsGoogleMap.settings.language'] ?? ''),
            'jquery' => $siteSettings['nsGoogleMap.settings.jquery'] ?? '',
            'enableGdpr' => $siteSettings['nsGoogleMap.settings.enableGdpr'] ?? '',
            'description' => (string)($siteSettings['nsGoogleMap.settings.description'] ?? ''),
            'noticeColor' => (string)($siteSettings['nsGoogleMap.settings.noticeColor'] ?? ''),
            'bgImage' => (string)($siteSettings['nsGoogleMap.settings.bgImage'] ?? ''),
            'bgColor' => (string)($siteSettings['nsGoogleMap.settings.bgColor'] ?? ''),
            'buttonText' => (string)($siteSettings['nsGoogleMap.settings.buttonText'] ?? ''),
            'activeAllButtonText' => (string)($siteSettings['nsGoogleMap.settings.activeAllButtonText'] ?? ''),
            'buttonTextColor' => (string)($siteSettings['nsGoogleMap.settings.buttonTextColor'] ?? ''),
            'buttonColor' => (string)($siteSettings['nsGoogleMap.settings.buttonColor'] ?? ''),
        ];
    }

    /**
     * @param string $tableName
     * @param string $identifier
     * @param string $fieldName
     * @param string $elementName
     * @return string
     */
    protected function updateField($tableName, $identifier, $fieldName, $elementName)
    {
        $args = array_map(
            [GeneralUtility::class, 'quoteJSvalue'],
            [$tableName, $identifier, $fieldName, $elementName]
        );
        return sprintf('TBE_EDITOR.fieldChanged(%s);', implode(',', $args));
    }
}
