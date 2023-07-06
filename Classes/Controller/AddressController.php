<?php
namespace Nitsan\NsGoogleMap\Controller;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Nitsan\NsGoogleMap\Domain\Repository\AddressRepository;
/***
 *
 * This file is part of the "[Nitsan] Google Map" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2023
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
     */
    protected $addressRepository;

    /**
     * contentObj
     */
    protected $contentObj = null;    

    public function __construct(AddressRepository $addressRepository){
        $this->addressRepository = $addressRepository;
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): ResponseInterface
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
        $this->view->assignMultiple(
            [
                'locations' => $address,
                'data' => $data
            ]
        );
        return $this->htmlResponse();
    }
}
