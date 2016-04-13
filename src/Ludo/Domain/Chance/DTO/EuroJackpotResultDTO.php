<?php

namespace Ludo\Domain\Chance\DTO;

class EuroJackpotResultDTO extends LotteryResultDTO
{
    /** @var integer[] */
    private $euroNumbers;

    /**
     * @return integer[]
     */
    public function getEuroNumbers()
    {
        return $this->euroNumbers;
    }

    /**
     * @param integer[] $euroNumbers
     */
    public function setEuroNumbers($euroNumbers)
    {
        $this->euroNumbers = $euroNumbers;
    }
}