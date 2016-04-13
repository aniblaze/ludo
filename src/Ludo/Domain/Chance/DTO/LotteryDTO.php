<?php

namespace Ludo\Domain\Chance\DTO;


class LotteryDTO
{
    /** @var integer */
    private $year;
    /** @var LotteryResultDTO[] */
    private $results;

    /**
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param integer $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return LotteryResultDTO[]
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param LotteryResultDTO[] $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * @param LotteryResultDTO $result
     */
    public function addResult(LotteryResultDTO $result)
    {
        $this->results[] = $result;
    }
}