<?php

namespace App\Controller\Api;

use App\Entity\Session;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EventSessionController extends AbstractController
{
    #[Route('/api/events/{id}/sessions', name: 'api_event_sessions', methods: ['GET'])]
    public function sessionsByEvent(int $id, EntityManagerInterface $em): JsonResponse
    {
        $event = $em->getRepository(Event::class)->find($id);

        if (!$event) {
            return $this->json(['error' => 'Event not found'], 404);
        }

        $sessions = $em->getRepository(Session::class)->findBy(['event' => $event]);

        // Utilise le groupe de sérialisation "session_read" si tu veux filtrer les champs
        return $this->json($sessions, 200, [], ['groups' => ['session_read']]);
    }
} 