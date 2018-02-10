<?php

namespace Ruwork\PolyfillFormDTI\Tests\Extension;

use Ruwork\PolyfillFormDTI\DTIExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Test\TypeTestCase;

class DateTypeDTIExtensionTest extends TypeTestCase
{
    public function testSubmitDateTimeImmutable()
    {
        $form = $this->factory->create(DateType::class, null, [
            'model_timezone' => 'UTC',
            'view_timezone' => 'UTC',
            'widget' => 'choice',
            'years' => [2010],
            'input' => 'datetime_immutable',
        ]);

        $form->submit([
            'day' => '2',
            'month' => '6',
            'year' => '2010',
        ]);

        $actual = $form->getData();

        $expected = new \DateTimeImmutable('2010-06-02 UTC');

        $this->assertInstanceOf(\DateTimeImmutable::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testSubmitDifferentTimezonesDateTimeImmutable()
    {
        $form = $this->factory->create(DateType::class, null, [
            'model_timezone' => 'America/New_York',
            'view_timezone' => 'Pacific/Tahiti',
            'widget' => 'single_text',
            'input' => 'datetime_immutable',
        ]);

        $form->submit('2010-06-02');

        $actual = $form->getData();

        $expected = (new \DateTimeImmutable('2010-06-02 Pacific/Tahiti'))
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
