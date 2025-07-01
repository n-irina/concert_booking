<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(Events::prePersist, method: 'prePersist', entity: User::class)]
#[AsEntityListener(Events::preUpdate, method: 'preUpdate', entity: User::class)]
class HashPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        // Add ROLE_USER role if no role is defined
        if (empty($entity->getRoles())) {
            $entity->setRoles(['ROLE_USER']);
        }

        // Hash password if necessary
        if ($entity->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword());
            $entity->setPassword($hashedPassword);
            $entity->eraseCredentials();
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        if ($entity->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword());
            $entity->setPassword($hashedPassword);
            $entity->eraseCredentials();
        }
    }
}