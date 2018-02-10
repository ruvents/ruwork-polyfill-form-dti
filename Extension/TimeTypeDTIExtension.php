<?php

namespace Ruwork\PolyfillFormDTI\Extension;

use Symfony\Component\Form\Extension\Core\Type\TimeType;

final class TimeTypeDTIExtension extends AbstractDTIExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return TimeType::class;
    }
}
