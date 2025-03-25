<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

final class PastEventsFilter extends AbstractFilter
{
    /**
     * @param string[] $properties
     */
    public function __construct(ManagerRegistry $managerRegistry, ?LoggerInterface $logger = null, ?array $properties = null, ?NameConverterInterface $nameConverter = null)
    {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
    }

    protected function filterProperty(string $property, mixed $value, QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass,
        ?Operation $operation = null, array $context = []): void
    {
        if ('future' !== $property) {
            return;
        }

        if ('false' !== $value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $today = new \DateTime();

        $queryBuilder
        ->innerJoin(sprintf('%s.sessions', $alias), 'es')
        ->andWhere('es.date_time < :date')
        ->setParameter('date', $today);
    }

    public function getDescription(string $resourceClass): array
    {
        return [];
    }
}
