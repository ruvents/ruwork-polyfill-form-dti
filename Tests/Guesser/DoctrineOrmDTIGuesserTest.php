<?php

namespace Ruwork\PolyfillFormDTI\Tests\Guesser;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Ruwork\PolyfillFormDTI\Guesser\DoctrineOrmDTIGuesser;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;

class DoctrineOrmDTIGuesserTest extends TestCase
{
    public function testGuessNulls()
    {
        $guesser = new DoctrineOrmDTIGuesser($this->createMock(ManagerRegistry::class));

        $this->assertNull($guesser->guessRequired('Class', 'property'));
        $this->assertNull($guesser->guessMaxLength('Class', 'property'));
        $this->assertNull($guesser->guessPattern('Class', 'property'));
    }

    /**
     * @dataProvider generateTypeGuessData
     */
    public function testTypeGuess(ManagerRegistry $registry = null, TypeGuess $expectedGuess = null)
    {
        $guesser = new DoctrineOrmDTIGuesser($registry);

        $this->assertEquals($guesser->guessType('Class', 'property'), $expectedGuess);
    }

    public function generateTypeGuessData()
    {
        $registry = $this->createRegistry(null);
        yield [$registry, null];

        $manager = $this->createManager(null);
        $registry = $this->createRegistry($manager);
        yield [$registry, null];

        $metadata = $this->createMetadata(null, false);
        $manager = $this->createManager($metadata);
        $registry = $this->createRegistry($manager);
        yield [$registry, null];

        $metadata = $this->createMetadata('text');
        $manager = $this->createManager($metadata);
        $registry = $this->createRegistry($manager);
        yield [$registry, null];

        $metadata = $this->createMetadata('datetime_immutable');
        $manager = $this->createManager($metadata);
        $registry = $this->createRegistry($manager);
        $guess = $this->createGuess(DateTimeType::class);
        yield [$registry, $guess];

        $metadata = $this->createMetadata('date_immutable');
        $manager = $this->createManager($metadata);
        $registry = $this->createRegistry($manager);
        $guess = $this->createGuess(DateType::class);
        yield [$registry, $guess];

        $metadata = $this->createMetadata('time_immutable');
        $manager = $this->createManager($metadata);
        $registry = $this->createRegistry($manager);
        $guess = $this->createGuess(TimeType::class);
        yield [$registry, $guess];
    }

    private function createGuess($type)
    {
        return new TypeGuess($type, ['input' => 'datetime_immutable'], Guess::HIGH_CONFIDENCE);
    }

    private function createRegistry(ObjectManager $manager = null)
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->method('getManagerForClass')->willReturn($manager);

        return $registry;
    }

    private function createManager(ClassMetadata $metadata = null)
    {
        $manager = $this->createMock(ObjectManager::class);
        $manager->method('getClassMetadata')->willReturn($metadata);

        return $manager;
    }

    private function createMetadata($type = null, $hasField = true)
    {
        $metadata = $this->createMock(ClassMetadata::class);
        $metadata->method('hasField')->willReturn($hasField);
        $metadata->method('getTypeOfField')->willReturn($type);

        return $metadata;
    }
}
