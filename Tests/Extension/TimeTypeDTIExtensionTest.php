<?php

namespace Ruwork\PolyfillFormDTI\Tests\Extension;

use Ruwork\PolyfillFormDTI\DTIExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Test\TypeTestCase;

class TimeTypeDTIExtensionTest extends TypeTestCase
{
    public function testSubmitDateTimeImmutable()
    {
        $form = $this->factory->create(TimeType::class, null, [
            'model_timezone' => 'UTC',
            'view_timezone' => 'UTC',
            'widget' => 'choice',
            'input' => 'datetime_immutable',
        ]);

        $form->submit([
            'hour' => '3',
            'minute' => '4',
        ]);

        $actual = $form->getData();

        $expected = new \DateTimeImmutable('1970-01-01 03:04:00 UTC');

        $this->assertInstanceOf(\DateTimeImmutable::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testSubmitDifferentTimezonesDateTimeImmutable()
    {
        $form = $this->factory->create(TimeType::class, null, [
            'model_timezone' => 'America/New_York',
            'view_timezone' => 'Pacific/Tahiti',
            'widget' => 'single_text',
            'input' => 'datetime_immutable',
        ]);

        $form->submit('03:04');

        $actual = $form->getData();

        $expected = (new \DateTimeImmutable('1970-01-01 03:04:00 Pacific/Tahiti'))
            ->setTimezone(new \DateTimeZone('America/New_York'));

        $this->assertInstanceOf(\DateTimeImmutable::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    protected function getExtensions()
    {
        return [
            new DTIExtension(),
        ];
    }
}
