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
     * @inject
     */
    protected $addressRepository = null;

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

        $maptypes = explode(",", $this->settings['maptype']);
        $this->view->assign('locations', $address);
        $this->view->assign('maptypes', $maptypes);
        $this->view->assign('data', $data);
    }
}
