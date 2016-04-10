<?php

namespace BatteriesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BatteryRepository
 */
class BatteryRepository extends EntityRepository
{
    /**
     * Returns statistics.
     *
     * @return array
     */
    public function getStatistics()
    {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.count) AS stat_count, b.type')
            ->groupBy('b.type')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Delete all batteries.
     *
     * @return mixed
     */
    public function deleteAll()
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->delete($this->getClassName())
            ->getQuery()
            ->execute();
    }
}
