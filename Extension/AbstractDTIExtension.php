<?php

namespace Ruwork\PolyfillFormDTI\Extension;

use Ruwork\PolyfillFormDTI\DataTransformer\DateTimeImmutableToDateTimeTransformer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDTIExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ('datetime_immutable' === $options['input']) {
            $builder->addModelTransformer(new DateTimeImmutableToDateTimeTransformer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->addAllowedValues('input', ['datetime_immutable']);
    }
}
