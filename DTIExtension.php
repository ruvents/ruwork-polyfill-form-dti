<?php

namespace Ruwork\PolyfillFormDTI;

use Ruwork\PolyfillFormDTI\Extension\DateTimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\DateTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\TimeTypeDTIExtension;
use Symfony\Component\Form\AbstractExtension;

final class DTIExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions()
    {
        return [
            new DateTimeTypeDTIExtension(),
            new DateTypeDTIExtension(),
            new TimeTypeDTIExtension(),
        ];
    }
}
