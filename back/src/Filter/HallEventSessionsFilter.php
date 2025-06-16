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

    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass,
        ?Operation $operation = null, array $context = []): void
    {
        $alias = $queryBuilder->getRootAliases()[0];
        if ($property === 'hall') {
            $queryBuilder
                ->innerJoin(sprintf('%s.hall', $alias), 'hall')
                ->andWhere('hall.id = :hallId')
                ->setParameter('hallId', $value);
            return;
        }
    
        // Filtrer par ID d’événement
        if ($property === 'event') {
            $queryBuilder
                ->innerJoin(sprintf('%s.event', $alias), 'event')
                ->andWhere('event.id = :eventId')
                ->setParameter('eventId', $value);
            return;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'hall' => [
                'property' => null,
                'type' => 'integer',
                'required' => false,
                'swagger' => ['description' => 'Filter sessions by hall Id'],
            ],
            'event' => [
                'property' => null,
                'type' => 'integer',
                'required' => false,
                'swagger' => ['description' => 'Filter sessions by event ID'],
            ],
        ];
    }
}
