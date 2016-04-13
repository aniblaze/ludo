<?php

namespace Ludo\Framework\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

class CustomDateType extends DateType
{
    /** string */
    const NAME = 'customdate';

    /**
     * @inheritdoc
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $date = parent::convertToPHPValue($value, $platform);

        if (!$date)
            return $date;

        return new CustomDate('@' . $date->format('U'));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::NAME;
    }
}