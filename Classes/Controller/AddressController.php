<?php
namespace Nitsan\NsGoogleMap\Controller;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility as debug;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***
 *
 * This file is part of the "[Nitsan] Google Map" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * AddressController
 */
class AddressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * addressRepository
     *
     * @var \Nitsan\NsGoogleMap\Domain\Repository\AddressRepository
     * @inject
     */
    protected $addressRepository = null;

    public function initializeAction() {
        /** @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $googleMapsLibrary = 'https://maps.google.com/maps/api/js?';

        if ($this->settings['apiKey']) {
            $googleMapsLibrary .= '&key=' . $this->settings['apiKey'];
        }
        
        if ($this->settings['language']) {
            $googleMapsLibrary .= '&language=' . $this->settings['language'].'&libraries=places';
        }
        $cluster = "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js";
        $pageRenderer->addJsFooterFile($googleMapsLibrary, $type = "text/javascript", $compress = true);
        $pageRenderer->addJsFooterFile($cluster, $type = "text/javascript", $compress = true);
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $setting = $this->settings;
        $this->contentObj = $this->configurationManager->getContentObject();
        $data = $this->contentObj->data;
        
        // Set storage page id from tt_content
        $pid = $data['pages'];
        if($pid != ''){
            $querySettings = $this->addressRepository->createQuery()->getQuerySettings();
            $querySettings->setStoragePageIds(array($pid));
            $this->addressRepository->setDefaultQuerySettings($querySettings);
        }

        if(empty($this->settings['address'])){
            $address = $this->addressRepository->findAll()->toArray();    
        }
        else{
            $addressId = explode(',', $this->settings['address']);
            $address = $this->addressRepository->findAddress($addressId)->toArray();
        }
        
        $maptypes = explode(",", $this->settings['maptype']);
        $this->view->assign('locations',$address);
        $this->view->assign('maptypes',$maptypes);
        $this->view->assign('data',$data);
    }
}
