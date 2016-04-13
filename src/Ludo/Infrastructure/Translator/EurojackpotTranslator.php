<?php

namespace Ludo\Infrastructure\Translator;


use DateTime;
use Ludo\Domain\Chance\DTO\EuroJackpotResultDTO;
use Ludo\Domain\Chance\DTO\LotteryDTO;
use Ludo\Domain\Chance\DTO\LotteryResultDTO;
use Ludo\Domain\Chance\Particle;

/**
 * The Eurojackpot translator allows a set of particles to be transformed into a human readable data transfer objects,
 * which shows a set of winning number for a given date, in a given year.
 *
 * @package Ludo\Infrastructure\Translator
 */
class EurojackpotTranslator
{
    /** @var Particle[] */
    private $particles;

    /**
     * Eurojackpot constructor.
     *
     * @param Particle[] $particles
     */
    public function __construct($particles)
    {
        $this->setParticles($particles);
    }

    public function translate()
    {
        $lotteryResults = $this->getEuroJackpotResults();
        $lotteries      = $this->getEuroJackpots($lotteryResults);

        return $lotteries;
    }

    /**
     * @return Particle[]
     */
    public function getParticles()
    {
        return $this->particles;
    }

    /**
     * @param Particle[] $particles
     */
    public function setParticles($particles)
    {
        $this->particles = $particles;
    }

    /**
     * Get the eurojackpot lottery of a given year.
     *
     * @param LotteryDTO[]  $lottery
     * @param string        $year
     *
     * @return LotteryDTO
     */
    private function getLotteryPerYear($lottery, $year)
    {
        return (key_exists($year, $lottery)) ? $lottery[$year] : new LotteryDTO();
    }

    /**
     * Get the lottery results per date.
     *
     * @param EuroJackpotResultDTO[]    $lotteryResult
     * @param DateTime                  $date
     *
     * @return LotteryResultDTO
     */
    private function getEuroJackpotResultPerDate($lotteryResult, DateTime $date)
    {
        $lotteryYear = (key_exists($date->format('Y'), $lotteryResult))
            ? $lotteryResult[$date->format('Y')]
            : $lotteryResult[$date->format('Y')] = [];

        $lotteryDate = (key_exists($date->format('Y-m-d'), $lotteryYear))
            ? $lotteryYear[$date->format('Y-m-d')]
            : new EuroJackpotResultDTO();

        return $lotteryDate;
    }

    /**
     * Get a collection of particles, and translate them to the proper DTO's.
     *
     * @return EuroJackpotResultDTO[]
     */
    private function getEuroJackpotResults()
    {
        $euroJackpotResult  = [];

        foreach ($this->getParticles() as $particle)
        {
            $lotteryResult = $this->getEuroJackpotResultPerDate($euroJackpotResult, $particle->getDate());
            $lotteryResult->setTimestamp($particle->getDate()->getTimestamp());
            $lotteryResult->addNumber($particle->getName());

            $euroJackpotResult[$lotteryResult->getDate()->format('Y')][$lotteryResult->getDate()->format('Y-m-d')] = $lotteryResult;
        }

        return $euroJackpotResult;
    }

    /**
     * Get all of the euro jackpots per year.
     *
     * @param array $euroJackpots
     *
     * @return LotteryDTO[]
     */
    private function getEuroJackpots($euroJackpots)
    {
        $euroJackpot = [];

        foreach ($euroJackpots as $year => $euroJackpotResults)
        {
            $lottery = $this->getLotteryPerYear($euroJackpot, $year);
            $lottery->setYear($year);

            foreach ($euroJackpotResults as $euroJackpotResult)
            {
                $lottery->addResult($euroJackpotResult);
            }

            $euroJackpot[] = $lottery;
        }

        return $euroJackpot;
    }
}