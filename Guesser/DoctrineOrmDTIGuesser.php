<?php

namespace Ruwork\PolyfillFormDTI\Guesser;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;

final class DoctrineOrmDTIGuesser implements FormTypeGuesserInterface
{
    private $registry;

    /**
     * @var ClassMetadata[]
     */
    private $metadataCache = [];

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function guessType($class, $property)
    {
        $metadata = $this->getMetadata($class);

        if (null === $metadata) {
            return null;
        }

        if (!$metadata->hasField($property)) {
            return null;
        }

        switch ($metadata->getTypeOfField($property)) {
            case 'datetimetz_immutable':
            case 'datetime_immutable':
                return $this->createGuess(DateTimeType::class);

            case 'date_immutable':
                return $this->createGuess(DateType::class);

            case 'time_immutable':
                return $this->createGuess(TimeType::class);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function guessRequired($class, $property)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function guessMaxLength($class, $property)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function guessPattern($class, $property)
    {
        return null;
    }

    /**
     * @param string $type
     *
     * @return TypeGuess
     */
    private function createGuess($type)
    {
        return new TypeGuess($type, ['input' => 'datetime_immutable'], Guess::HIGH_CONFIDENCE);
    }

    /**
     * @param string $class
     *
     * @return null|ClassMetadata
     */
    private function getMetadata($class)
    {
        $class = ClassUtils::getRealClass(ltrim($class, '\\'));

        if (!array_key_exists($class, $this->metadataCache)) {
            $this->metadataCache[$class] = null;

            if (null !== $manager = $this->registry->getManagerForClass($class)) {
                $this->metadataCache[$class] = $manager->getClassMetadata($class);
            }
        }

        return $this->metadataCache[$class];
    }
}
