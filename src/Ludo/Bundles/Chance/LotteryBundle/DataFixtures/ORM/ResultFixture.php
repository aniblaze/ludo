<?php

namespace Ludo\Bundles\Chance\LotteryBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ludo\Domain\Chance\Distributor;
use Ludo\Domain\Chance\DTO\EuroJackpotResultDTO;
use Ludo\Domain\Chance\Network;
use Ludo\Domain\Chance\Particle;
use Ludo\Framework\Doctrine\Type\CustomDate;
use Ludo\Infrastructure\Importer\EuroJackpotImporter;

class ResultFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadEurojackpot($manager);
    }

    /**
     * Load data fixtures pertaining to the Eurojackpot company.
     *
     * @param ObjectManager $manager
     */
    public function loadEurojackpot(ObjectManager $manager)
    {
        $euroJackpotImporter    = new EuroJackpotImporter();
        $euroJackpotResults = $euroJackpotImporter->getResults();

        foreach ($euroJackpotResults as $euroJackpotDTO)
        {
            foreach ($euroJackpotDTO->getResults() as $euroJackpotResultDTO)
            {
                $this->loadEuroJackpotParticles($manager, $euroJackpotResultDTO);
            }
        }
    }

    /**
     * Load the particles of a winning month.
     *
     * @param ObjectManager         $manager
     * @param EuroJackpotResultDTO  $euroJackpotResultDTO
     */
    public function loadEuroJackpotParticles(ObjectManager $manager, EuroJackpotResultDTO $euroJackpotResultDTO)
    {
        $particles = $this->createParticles($manager, $euroJackpotResultDTO);
        $this->createParticleNetwork($manager, $euroJackpotResultDTO, $particles);
    }

    /**
     * Persist all of the result numbers as particles.
     *
     * @param ObjectManager $manager
     * @param EuroJackpotResultDTO $euroJackpotResultDTO
     *
     * @return Particle[]
     */
    private function createParticles(ObjectManager $manager, EuroJackpotResultDTO $euroJackpotResultDTO)
    {
        /** @var Distributor $distributor */
        $distributor    = $this->getReference(DistributorFixture::REFERENCE_EUROJACKPOT);
        $particles      = array();

        foreach ($euroJackpotResultDTO->getNumbers() as $number)
        {
            $particle = new Particle();
            $particle->setName($number);
            $particle->setDate($euroJackpotResultDTO->getDate());
            $particle->setCreated(new DateTime());
            $particle->setUpdated(new DateTime());
            $particle->setDistributor($distributor);

            $manager->persist($particle);
            $particles[] = $particle;
        }

        $manager->flush();

        return $particles;
    }

    /**
     * Create a network between the particles, showing their relation to one another, to allow an algorithm to see
     * relations in terms of dates and numbers.
     *
     * @param ObjectManager         $manager
     * @param EuroJackpotResultDTO  $euroJackpotResultDTO
     * @param Particle[]            $particles
     */
    private function createParticleNetwork(ObjectManager $manager, EuroJackpotResultDTO $euroJackpotResultDTO, $particles)
    {
        foreach ($particles as $particle)
        {
            foreach ($particles as $subParticle)
            {
                if ($particle->getName() !== $subParticle->getName())
                {
                    $network = new Network();
                    $network->setDate(new CustomDate($euroJackpotResultDTO->getDate()->format(Network::DATE_FORMAT)));
                    $network->setParent($particle);
                    $network->setChild($subParticle);
                    $manager->persist($network);
                }
            }
        }

        $manager->flush();
    }

    /**
     * Load data fixtures pertaining to the state lottery.
     *
     * @param ObjectManager $manager
     */
    public function loadStateLottery(ObjectManager $manager)
    {

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}