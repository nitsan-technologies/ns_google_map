<?php

namespace Nitsan\NsGoogleMap\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility as debug;

/***************************************************************
 *  Copyright notice
 *
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

/**
 * Google map.
 *
 */
class MapUtilityV8 {

	/**
	 * Renders the Google map.
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $pObj
	 * @return string
	 */
	public function render(array &$PA, $pObj) {
		
		$version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
		$settings = $this->loadTS($PA['row']['pid']);
		$pluginSettings = $settings['plugin.']['tx_nsgooglemap_map.']['settings.'];

		$googleMapsLibrary = 'http://maps.googleapis.com/maps/api/js?libraries=places';


		$googleMapJs = '../typo3conf/ext/ns_google_map/Resources/Public/Js/googleMap.js';
		$mapJs = '../typo3conf/ext/ns_google_map/Resources/Public/Js/autocompletemap.js';

		if ($pluginSettings['apiKey']) {
			$googleMapsLibrary .= '&key=' . $pluginSettings['apiKey'];
		}
		
		$out = [];
		$latitude = (float)$PA['row'][$PA['parameters']['latitude']];
		$longitude = (float)$PA['row'][$PA['parameters']['longitude']];
		$address = $PA['row'][$PA['parameters']['address']];

		$baseElementId = isset($PA['itemFormElID']) ? $PA['itemFormElID'] : $PA['table'] . '_map';
		$addressId = $baseElementId . '_address';
		$mapId = $baseElementId . '_map';

		if (!($latitude && $longitude)) {
			$latitude = 0;
			$longitude = 0;
		};
		$dataPrefix = 'data[' . $PA['table'] . '][' . $PA['row']['uid'] . ']';
		$latitudeField = $dataPrefix . '[' . $PA['parameters']['latitude'] . ']';
		$longitudeField = $dataPrefix . '[' . $PA['parameters']['longitude'] . ']';
		$addressField = $dataPrefix . '[' . $PA['parameters']['address'] . ']';

		$updateJs = "TBE_EDITOR.fieldChanged('%s','%s','%s','%s');";
		$updateLatitudeJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['latitude'],
			$latitudeField
		);
		$updateLongitudeJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['longitude'],
			$longitudeField
		);
		$updateAddressJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['address'],
			$addressField
		);		
		$out[] = '<script src="' . $googleMapsLibrary . '"></script>';
		$out[] = '<script type="text/javascript" src="' . $googleMapJs . '"></script>';
		$out[] = '<script type="text/javascript" src="' . $mapJs . '"></script>';
		$out[] = '<input type="hidden" value="'.$latitude.'" class="latitude"/>';
		$out[] = '<input type="hidden" value="'.$longitude.'" class="longitude"/>';
		$out[] = '<input type="hidden" value="'.$mapId.'" class="mapId"/>';
		$out[] = '<input type="hidden" value="'.$addressId.'" class="addressId"/>';
		$out[] = '<input type="hidden" value="'.$latitudeField.'" class="latitudeField"/>';
		$out[] = '<input type="hidden" value="'.$longitudeField.'" class="longitudeField"/>';
		$out[] = '<input type="hidden" value="'.$addressField.'" class="addressField"/>';
		$out[] = '<input type="hidden" value="'.$updateLatitudeJs.'" class="updateLatitudeJs"/>';
		$out[] = '<input type="hidden" value="'.$updateLongitudeJs.'" class="updateLongitudeJs"/>';
		$out[] = '<input type="hidden" value="'.$updateAddressJs.'" class="updateAddressJs"/>';
		$out[] = '<input type="hidden" value="'.$version.'" class="version"/>';
		$out[] = '<div id="' . $baseElementId . '">';
		$out[] = '
			<input id="' . $addressId . '" type="textbox" value="' . $address . '" class="origin" style="width:300px">
			<input type="button" value="Update" onclick="GoogleMap.codeAddress()">
		';
		$out[] = '<div id="' . $mapId . '" style="height:400px;margin:10px 0;width:400px"></div>';
		$out[] = '</div>'; // id=$baseElementId

		return implode('', $out);
	}

	protected function loadTS($pageUid) {
		$sysPageObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Frontend\\Page\\PageRepository'
		);
		$rootLine = $sysPageObj->getRootLine($pageUid);
		$TSObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService'
		);
		$TSObj->tt_track = 0;
		$TSObj->init();
		$TSObj->runThroughTemplates($rootLine);
		$TSObj->generateConfig();

		return $TSObj->setup;
	}
}