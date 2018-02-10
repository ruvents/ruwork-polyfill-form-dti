<?php

namespace Ruwork\PolyfillFormDTI\Extension;

use Symfony\Component\Form\Extension\Core\Type\DateType;

final class DateTypeDTIExtension extends AbstractDTIExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return DateType::class;
    }
}
