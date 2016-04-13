<?php

namespace Ludo\Domain\Chance;

use DateTime;

class Network
{
    const DATE_FORMAT = 'Y-m-d';

    /** @var Particle */
    private $parent;
    /** @var Particle */
    private $child;
    /** @var DateTime */
    private $date;

    /**
     * @return Particle
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Particle $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Particle
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param Particle $child
     */
    public function setChild($child)
    {
        $this->child = $child;
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
}