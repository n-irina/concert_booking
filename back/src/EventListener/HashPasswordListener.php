<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(Events::prePersist, method: 'prePersist', entity: User::class)]
#[AsEntityListener(Events::preUpdate, method: 'preUpdate', entity: User::class)]
class HashPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    // 👇 ici, on reçoit l'entité directement
    public function prePersist(User $user): void
    {
        if (empty($user->getRoles())) {
            $user->setRoles(['ROLE_USER']);
        }

        if ($user->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);
            $user->eraseCredentials();
        }
    }

    public function preUpdate(User $user): void
    {
        if ($user->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);
            $user->eraseCredentials();
        }
    }
}
