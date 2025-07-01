<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class HallEventSessionsFilter extends AbstractFilter
{
    /**
     * @param string[] $properties
     */
    public function __construct(ManagerRegistry $managerRegistry,?LoggerInterface $logger = null,?array $properties = null,?NameConverterInterface $nameConverter = null) 
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if ($property !== 'hall' && $property !== 'eventId') {
            return;
        }

        $parameterName = $queryNameGenerator->generateParameterName($property);
        
        if ($property === 'hall') {
            $queryBuilder
                ->andWhere(sprintf('o.hall = :%s', $parameterName))
                ->setParameter($parameterName, $value);
        }
        
        if ($property === 'eventId') {
            // Filter by event ID
            $queryBuilder
                ->andWhere(sprintf('o.event = :%s', $parameterName))
                ->setParameter($parameterName, $value);
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'hall' => [
                'property' => 'hall',
                'type' => 'string',
                'required' => false,
                'description' => 'Filter sessions by hall ID',
            ],
            'eventId' => [
                'property' => 'eventId',
                'type' => 'string',
                'required' => false,
                'description' => 'Filter sessions by event ID',
            ],
        ];
    }
}
