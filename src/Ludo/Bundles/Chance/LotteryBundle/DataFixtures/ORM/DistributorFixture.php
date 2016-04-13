<?php

namespace Ludo\Bundles\Chance\LotteryBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ludo\Domain\Chance\Distributor;

class DistributorFixture extends AbstractFixture implements OrderedFixtureInterface
{

    const REFERENCE_EUROJACKPOT     = 'euro-jackpot';
    const REFERENCE_STATELOTTERY    = 'state-lottery';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dateTime = new DateTime();

        $euroJackpot = new Distributor();
        $euroJackpot->setName('Euro Jackpot');
        $euroJackpot->setCode('EURO_JACKPOT');
        $euroJackpot->setCreated($dateTime);
        $euroJackpot->setUpdated($dateTime);
        $manager->persist($euroJackpot);
        $this->addReference(self::REFERENCE_EUROJACKPOT, $euroJackpot);

        $stateLottery = new Distributor();
        $stateLottery->setName('State Lottery');
        $stateLottery->setCode('STATE_LOTTERY');
        $stateLottery->setCreated($dateTime);
        $stateLottery->setUpdated($dateTime);
        $manager->persist($stateLottery);
        $this->addReference(self::REFERENCE_STATELOTTERY, $stateLottery);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}