<?php

namespace BatteriesBundle\Services;

use BatteriesBundle\Entity\Battery;
use Doctrine\ORM\EntityManager;
use BatteriesBundle\Entity\BatteryRepository;

class BatteriesService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var BatteryRepository
     */
    private $repository;
    
    public function __construct(EntityManager $entityManager, BatteryRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * Get batteries statistic.
     *
     * @return array
     */
    public function getStatistic()
    {
        return $this->repository->getStatistics();
    }

    /**
     * Save battery.
     *
     * @param Battery $battery
     *
     * @return void
     */
    public function saveBattery(Battery $battery)
    {
        $this->entityManager->persist($battery);
        $this->entityManager->flush($battery);
    }
}
