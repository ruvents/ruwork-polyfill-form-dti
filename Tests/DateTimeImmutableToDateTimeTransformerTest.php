<?php

namespace Ruwork\PolyfillFormDTI\Tests;

use PHPUnit\Framework\TestCase;
use Ruwork\PolyfillFormDTI\DateTimeImmutableToDateTimeTransformer;

class DateTimeImmutableToDateTimeTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $input = new \DateTimeImmutable('2010-02-03 04:05:06 UTC');

        $expectedOutput = new \DateTime('2010-02-03 04:05:06 UTC');
        $actualOutput = $transformer->transform($input);

        $this->assertInstanceOf('\DateTime', $actualOutput);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testTransformNull()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $this->assertNull($transformer->transform(null));
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a \DateTimeImmutable.
     */
    public function testTransformFail()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $transformer->transform(new \DateTime());
    }

    public function testReverseTransform()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $input = new \DateTime('2010-02-03 04:05:06 UTC');

        $expectedOutput = new \DateTimeImmutable('2010-02-03 04:05:06 UTC');
        $actualOutput = $transformer->reverseTransform($input);

        $this->assertInstanceOf('\DateTimeImmutable', $actualOutput);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testReverseTransformNull()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $this->assertNull($transformer->reverseTransform(null));
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a \DateTime.
     */
    public function testReverseTransformFail()
    {
        $transformer = new DateTimeImmutableToDateTimeTransformer();

        $transformer->reverseTransform(new \DateTimeImmutable());
    }
}
