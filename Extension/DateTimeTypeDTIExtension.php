<?php

namespace Ruwork\PolyfillFormDTI\Extension;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

final class DateTimeTypeDTIExtension extends AbstractDTIExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return DateTimeType::class;
    }
}
