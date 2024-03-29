<?php
namespace Nitsan\NsGoogleMap\Domain\Repository;

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
 * The repository for Addresses
 */
class AddressRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param array $addressId
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAddress(array $addressId)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->in('uid', $addressId)
        );
        $result = $query->execute();
        return $result;
    }
}
