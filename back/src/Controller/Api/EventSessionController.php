<?php

namespace App\Controller\Api;

use App\Entity\Session;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SessionRepository;

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

        // Use "session_read" serialization group if you want to filter fields
        return $this->json($sessions, 200, [], ['groups' => ['session_read']]);
    }

    #[Route('/api/events/{eventId}/sessions', name: 'api_event_sessions', methods: ['GET'])]
    public function getEventSessions(
        int $eventId,
        Request $request,
        SessionRepository $sessionRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $sessions = $sessionRepository->findBy(['event' => $eventId]);
        
        // Use "session_read" serialization group if you want to filter fields
        $data = $serializer->serialize($sessions, 'json', ['groups' => ['session_read']]);
        
        return new JsonResponse(json_decode($data, true));
    }
} 