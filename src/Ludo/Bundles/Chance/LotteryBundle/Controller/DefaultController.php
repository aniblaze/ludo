<?php

namespace Ludo\Bundles\Chance\LotteryBundle\Controller;

use Ludo\Domain\Chance\Distributor;
use Ludo\Domain\Chance\DistributorRepository;
use Ludo\Domain\Chance\DTO\EuroJackpotResultDTO;
use Ludo\Domain\Chance\DTO\LotteryDTO;
use Ludo\Domain\Chance\ParticleRepository;
use Ludo\Framework\Controller\BaseController;
use Ludo\Infrastructure\Translator\EurojackpotTranslator;

class DefaultController extends BaseController
{
    /**
     * Retrieve all of the Eurojackpot results of the given year.
     *
     * @param integer $year
     *
     * @return LotteryDTO[]
     */
    public function euroJackpotResultsPerYearAction($year)
    {
        $distributorRepository  = new DistributorRepository($this->getEntityManager());
        $distributor            = $distributorRepository->getDistributor(Distributor::DISTRIBUTOR_EURO_JACKPOT);

        $particleRepository     = new ParticleRepository($this->getEntityManager());
        $particles              = $particleRepository->getParticlePerDistributorAndYear($distributor, $year);

        $euroJackpotTranslator  = new EurojackpotTranslator($particles);
        $euroJackpotDTO         = $euroJackpotTranslator->translate();

        return $euroJackpotDTO;
    }
    /**
     * Retrieve all of the Eurojackpot results.
     *
     * @return LotteryDTO[]
     */
    public function euroJackpotResultsAction()
    {
        $distributorRepository  = new DistributorRepository($this->getEntityManager());
        $distributor            = $distributorRepository->getDistributor(Distributor::DISTRIBUTOR_EURO_JACKPOT);

        $particleRepository     = new ParticleRepository($this->getEntityManager());
        $particles              = $particleRepository->getParticlePerdistributor($distributor);

        $euroJackpotTranslator  = new EurojackpotTranslator($particles);
        $euroJackpotDTO         = $euroJackpotTranslator->translate();

        return $euroJackpotDTO;
    }

    /**
     * Retrieve a prediction for this weeks' winning numbers.
     *
     * @return LotteryDTO
     */
    public function euroJackpotPredictionAction()
    {
        $distributorRepository  = new DistributorRepository($this->getEntityManager());
        $distributor            = $distributorRepository->getDistributor(Distributor::DISTRIBUTOR_EURO_JACKPOT);

        $particleRepository     = new ParticleRepository($this->getEntityManager());
        $particles              = $particleRepository->getPredictionPerDistributor($distributor, '');

        $euroJackpotTranslator  = new EurojackpotTranslator($particles);
        $euroJackpotDTO         = $euroJackpotTranslator->translate();

        return $euroJackpotDTO;
    }
}
