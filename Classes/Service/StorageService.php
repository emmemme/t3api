<?php
declare(strict_types=1);

namespace SourceBroker\T3api\Service;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class StorageService
 */
class StorageService implements SingletonInterface
{
    /**
     * @param int[] $storagePids
     * @param int $recursionDepth
     *
     * @return int[]
     */
    public static function getRecursiveStoragePids(array $storagePids, $recursionDepth = 0): array
    {
        if ($recursionDepth <= 0) {
            return $storagePids;
        }

        $recursiveStoragePids = [];

        foreach ($storagePids as $startPid) {
            $pids = $GLOBALS['TSFE']->cObj->getTreeList($startPid, $recursionDepth, 0);

            if (!empty($pids)) {
                $recursiveStoragePids = array_merge(
                    $recursiveStoragePids,
                    GeneralUtility::intExplode(',', $pids)
                );
            }
        }

        return array_unique($recursiveStoragePids);
    }

}
