<?php

namespace Ludo\Domain\Chance;

use DateTime;

class Distributor
{
    const DISTRIBUTOR_EURO_JACKPOT  = 'EURO_JACKPOT';
    const DISTRIBUTOR_STATE_LOTTERY = 'STATE_LOTTERY';

    /** @var integer */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $code;
    /** @var DateTime */
    private $created;
    /** @var DateTime */
    private $updated;
    /** @var Particle[] */
    private $particles;

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return Particle[]
     */
    public function getResults()
    {
        return $this->particles;
    }

    /**
     * @param Particle[] $particles
     */
    public function setResults($particles)
    {
        $this->particles = $particles;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}