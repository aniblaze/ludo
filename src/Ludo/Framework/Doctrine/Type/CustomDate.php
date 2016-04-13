<?php

namespace Ludo\Framework\Doctrine\Type;

use DateTime;

class CustomDate extends DateTime
{
    public function __toString()
    {
        return (string) $this->format('Y-m-d');
    }
}