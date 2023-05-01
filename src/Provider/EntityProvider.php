<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;
use Doctrine\ORM\EntityManagerInterface;

class EntityProvider implements FixtureProvider
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param string|int   $identifier
     * @param class-string $entityFqcn
     *
     * @return object|null
     */
    public function entity(string|int $identifier, string $entityFqcn): ?object
    {
        $repository = $this->entityManager->getRepository($entityFqcn);

        if (is_int($identifier)) {
            return $repository->find($identifier);
        }

        return $repository->findOneBy(['uuid' => $identifier]);
    }
}
