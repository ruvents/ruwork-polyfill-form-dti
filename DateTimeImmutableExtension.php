<?php

namespace Ruwork\PolyfillFormDTI;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

final class DateTimeImmutableExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions()
    {
        return [
            new DateTimeImmutableTypeExtension(DateTimeType::class),
            new DateTimeImmutableTypeExtension(DateType::class),
            new DateTimeImmutableTypeExtension(TimeType::class),
        ];
    }
}
