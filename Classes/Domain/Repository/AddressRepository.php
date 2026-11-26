<?php

declare(strict_types=1);

namespace Nitsan\NsGoogleMap\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Addresses
 */
class AddressRepository extends Repository
{
    /**
     * Find addresses by explicit UIDs (FlexForm selection).
     *
     * Storage-page restriction is disabled only for this path so editors can
     * pick records from any folder; UIDs must already be allow-listed via FlexForm.
     *
     * @param list<int> $addressId
     * @return QueryResultInterface
     */
    public function findAddress(array $addressId): QueryResultInterface
    {
        $addressId = array_values(array_unique(array_filter(
            array_map(static fn(mixed $uid): int => (int)$uid, $addressId),
            static fn(int $uid): bool => $uid > 0
        )));

        $query = $this->createQuery();
        if ($addressId === []) {
            return $query->matching($query->equals('uid', 0))->execute();
        }

        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->in('uid', $addressId));

        return $query->execute();
    }

    /**
     * Find all addresses in the plugin storage scope.
     *
     * When a storage PID is configured (tt_content.pages / TypoScript
     * persistence.storagePid), that scope is respected. Legacy installs with
     * no storage folder keep the previous “all records” behaviour so existing
     * maps without FlexForm selection do not go empty.
     *
     * @return QueryResultInterface
     */
    public function findAll(): QueryResultInterface
    {
        $query = $this->createQuery();
        if (!$this->hasConfiguredStoragePages($query->getQuerySettings()->getStoragePageIds())) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }

        return $query->execute();
    }

    /**
     * @param list<int|string> $storagePageIds
     */
    protected function hasConfiguredStoragePages(array $storagePageIds): bool
    {
        foreach ($storagePageIds as $pid) {
            if ((int)$pid > 0) {
                return true;
            }
        }

        return false;
    }
}
