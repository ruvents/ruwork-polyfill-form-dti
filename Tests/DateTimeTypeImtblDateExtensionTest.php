<?php

namespace Ruwork\PolyfillFormDTI\Tests;

use Ruwork\PolyfillFormDTI\DateTimeImmutableExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Test\TypeTestCase;

class DateTimeTypeImtblDateExtensionTest extends TypeTestCase
{
    public function testSubmitDateTimeImmutable()
    {
        $form = $this->factory->create(DateTimeType::class, null, [
            'model_timezone' => 'UTC',
            'view_timezone' => 'UTC',
            'date_widget' => 'choice',
            'years' => [2010],
            'time_widget' => 'choice',
            'input' => 'datetime_immutable',
        ]);

        $form->submit([
            'date' => [
                'day' => '2',
                'month' => '6',
                'year' => '2010',
            ],
            'time' => [
                'hour' => '3',
                'minute' => '4',
            ],
        ]);

        $actual = $form->getData();

        $expected = new \DateTimeImmutable('2010-06-02 03:04:00 UTC');

        $this->assertInstanceOf(\DateTimeImmutable::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testSubmitDifferentTimezonesDateTimeImmutable()
    {
        $form = $this->factory->create(DateTimeType::class, null, [
            'model_timezone' => 'America/New_York',
            'view_timezone' => 'Pacific/Tahiti',
            'widget' => 'single_text',
            'input' => 'datetime_immutable',
        ]);

        $form->submit('2010-06-02T03:04:00-10:00');

        $actual = $form->getData();

        $expected = new \DateTimeImmutable('2010-06-02 03:04:00 Pacific/Tahiti');
        $expected = $expected->setTimezone(new \DateTimeZone('America/New_York'));

        $this->assertInstanceOf(\DateTimeImmutable::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    protected function getExtensions()
    {
        return [
            new DateTimeImmutableExtension(),
        ];
    }
}
