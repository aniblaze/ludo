<?php

namespace Ludo\Domain\Chance;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DistributorRepository extends EntityRepository
{
    /**
     * ResultRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $classMetaData = $entityManager->getClassMetadata(Distributor::class);
        parent::__construct($entityManager, $classMetaData);
    }

    /**
     * Get a distributor using a distributor code.
     *
     * @param string $distributorCode
     *
     * @return Distributor
     */
    public function getDistributor($distributorCode)
    {
        return $this->findOneBy(array('code' => $distributorCode));
    }
}