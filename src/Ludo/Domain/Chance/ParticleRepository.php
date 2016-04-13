<?php

namespace Ludo\Domain\Chance;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ParticleRepository extends EntityRepository
{
    /**
     * ResultRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $classMetaData = $entityManager->getClassMetadata(Particle::class);
        parent::__construct($entityManager, $classMetaData);
    }

    /**
     * Retrieve particles based on the distributor and a year.
     *
     * @param Distributor   $distributor
     * @param string        $year
     *
     * @return Particle[]
     */
    public function getParticlePerDistributorAndYear(Distributor $distributor, $year)
    {
        $yearStart  = new DateTime($year . '-01-01');
        $yearEnd    = new DateTime($year . '-12-31');

        return $this->getParticlePerDistributorAndDate($distributor, $yearStart, $yearEnd);
    }

    /**
     * Retrieve particles based on the distributor.
     *
     * @param Distributor $distributor
     *
     * @return Particle[]
     */
    public function getParticlePerdistributor(Distributor $distributor)
    {
        return $this->getParticlePerDistributorAndDate($distributor);
    }

    /**
     * Retrieve a network based on the distributor and a from and to date.
     *
     * @param Distributor   $distributor
     * @param DateTime      $fromDate
     * @param DateTime      $toDate
     *
     * @return Particle[]
     */
    public function getParticlePerDistributorAndDate(Distributor $distributor, DateTime $fromDate = null, DateTime $toDate = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from(Particle::class, 'p');
        $qb->where('p.distributor = :distributor');
        $qb->orderBy('p.date');
        $qb->setParameter('distributor', $distributor->getId());

        if ($fromDate instanceof DateTime && $toDate instanceof DateTime)
        {
            $qb->andWhere('p.date BETWEEN :fromDate AND :toDate');
            $qb->setParameter('fromDate', $fromDate->format(Network::DATE_FORMAT));
            $qb->setParameter('toDate', $toDate->format(Network::DATE_FORMAT));
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Retrieve a prediction based on the law of large numbers.
     *
     * @param Distributor   $distributor
     * @param string        $algorithm
     *
     * @return Particle[]
     */
    public function getPredictionPerDistributor(Distributor $distributor, $algorithm)
    {
        // TODO: Implement algorithm based on the law of large numbers, using the 'Rainbow - logic by colors' as described by Renato Gianello.

        $sql    = 'SELECT * FROM particle WHERE distributor = :distributor GROUP BY name ORDER BY max(id) DESC LIMIT 6';
        $rsm    = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Particle::class, 'p');
        $query  = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter('distributor', $distributor->getId());

        return $query->getResult();
    }
}