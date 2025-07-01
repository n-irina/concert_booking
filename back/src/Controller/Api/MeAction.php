<?php

// src/Controller/Api/MeAction.php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class MeAction extends AbstractController
{
    // Method to get user information
    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function __invoke(): ?User
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('The logged in user is not an instance of App\Entity\User.');
        }

        return $user;
    }
}
