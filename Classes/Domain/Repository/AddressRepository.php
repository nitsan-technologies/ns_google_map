<?php
namespace Nitsan\NsGoogleMap\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

/***
 *
 * This file is part of the "Google Map" Extension for TYPO3 CMS.
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
    protected ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    /**
     * @param array $addressId
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAddress(array $addressId)
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_nsgooglemap_domain_model_address');
        $addressIds = array_values(array_filter(array_map('intval', $addressId), static function ($id) {
            return $id > 0;
        }));
        if ($addressIds == []) {
            return $queryBuilder
                ->select('*')
                ->from('tx_nsgooglemap_domain_model_address')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT))
                )
                ->executeQuery();
        }
        return $queryBuilder
                ->select('*')
                ->from('tx_nsgooglemap_domain_model_address')
                ->where(
                    $queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter($addressIds, Connection::PARAM_INT_ARRAY))
                )
                ->executeQuery();
    }
}
