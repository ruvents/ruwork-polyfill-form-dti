<?php

namespace Ruwork\PolyfillFormDTI;

use Symfony\Component\Form\AbstractExtension;

final class DateTimeImmutableExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions()
    {
        return array(
            new DateTimeImmutableTypeExtension('Symfony\Component\Form\Extension\Core\Type\DateTimeType'),
            new DateTimeImmutableTypeExtension('Symfony\Component\Form\Extension\Core\Type\DateType'),
            new DateTimeImmutableTypeExtension('Symfony\Component\Form\Extension\Core\Type\TimeType'),
        );
    }
}
