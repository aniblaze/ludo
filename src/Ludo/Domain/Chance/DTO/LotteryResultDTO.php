<?php

namespace Ludo\Domain\Chance\DTO;


use DateTime;

class LotteryResultDTO
{
    /** @var integer */
    private $timestamp;
    /** @var integer[] */
    private $numbers;

    /**
     * @return DateTime
     */
    public function getDate()
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($this->getTimestamp());

        return $dateTime;
    }

    /**
     * @return integer[]
     */
    public function getNumbers()
    {
        return $this->numbers;
    }

    /**
     * @param integer[] $numbers
     */
    public function setNumbers($numbers)
    {
        $this->numbers = $numbers;
    }

    /**
     * @param integer $number
     */
    public function addNumber($number)
    {
        $this->numbers[] = $number;
    }

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param integer $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
}