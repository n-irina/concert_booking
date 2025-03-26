<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class ArtistEventsFilter extends AbstractFilter
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
        if ('artist' !== $property) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->innerJoin(sprintf('%s.artist', $alias), 'artist')
            ->andWhere('artist.id = :id')
            ->setParameter('id', $value);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'artist' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'swagger' => ['description' => 'Filter events by hall name']
            ],
        ];
    }
}
