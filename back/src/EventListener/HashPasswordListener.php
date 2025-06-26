<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(Events::prePersist, method: 'onPrePersist', entity: User::class)]
#[AsEntityListener(Events::preUpdate, method: 'hashPassword', entity: User::class)]
class HashPasswordListener
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function onPrePersist(User $user): void
    {
        // Ajouter le rôle ROLE_USER si aucun rôle n'est défini
        if (empty($user->getRoles())) {
            $user->setRoles(['ROLE_USER']);
        }

        // Hacher le mot de passe si nécessaire
        $this->hashPassword($user);
    }

    public function hashPassword(User $user): void
    {
        // Only hash if plain_password is set and password is not already hashed
        if (!$user->getPlainPassword() || $user->getPassword()) {
            return;
        }
        
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        );
        $user->setPassword($hashedPassword);
    }
}