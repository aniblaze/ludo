<?php

namespace Ludo\Domain\Chance;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class NetworkRepository extends EntityRepository
{
    /**
     * ResultRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $classMetaData = $entityManager->getClassMetadata(Network::class);
        parent::__construct($entityManager, $classMetaData);
    }
}