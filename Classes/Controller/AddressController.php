<?php
namespace Nitsan\NsGoogleMap\Controller;

use TYPO3\CMS\Extbase\Annotation\Inject;

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
     */
    protected $addressRepository = null;

    /**
     * @param \Nitsan\NsGoogleMap\Domain\Repository\AddressRepository $addressRepository
     */
    public function injectAddressRepository(\Nitsan\NsGoogleMap\Domain\Repository\AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
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

        if (empty($this->settings['address'])) {
            $address = $this->addressRepository->findAll()->toArray();
        } else {
            $addressId = explode(',', $this->settings['address']);
            $address = $this->addressRepository->findAddress($addressId)->toArray();
        }
        $version = 'greater';
        if(version_compare(TYPO3_version, '8.0.0', '<=')){
            $version = 'less';
        }
        $maptype = $this->settings['maptype'] ?? null;
        if($maptype){
            $maptypes = explode(',', $this->settings['maptype']);
        } else {
            $maptypes = $maptype;
        }
        
        $this->view->assign('locations', $address);
        $this->view->assign('maptypes', $maptypes);
        $this->view->assign('data', $data);
        $this->view->assign('version', $version);
    }
}
