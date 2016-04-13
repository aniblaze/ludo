<?php

namespace Ludo\Domain\Chance;

use DateTime;

class Particle
{
    /** @var integer */
    private $id;
    /** @var Distributor */
    private $distributor;
    /** @var string */
    private $name;
    /** @var Network[] */
    private $network;
    /** @var DateTime */
    private $date;
    /** @var DateTime */
    private $created;
    /** @var DateTime */
    private $updated;

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
     * @return Distributor
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * @param Distributor $distributor
     */
    public function setDistributor($distributor)
    {
        $this->distributor = $distributor;
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
     * @return Network[]
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param Network[] $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
}