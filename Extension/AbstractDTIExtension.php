<?php

namespace Ruwork\PolyfillFormDTI\Extension;

use Ruwork\PolyfillFormDTI\DataTransformer\DateTimeImmutableToDateTimeTransformer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeImmutableToDateTimeTransformer as SymfonyTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDTIExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!class_exists(SymfonyTransformer::class) && 'datetime_immutable' === $options['input']) {
            $builder->addModelTransformer(new DateTimeImmutableToDateTimeTransformer(), true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        if (!class_exists(SymfonyTransformer::class)) {
            $resolver->addAllowedValues('input', ['datetime_immutable']);
        }
    }
}
