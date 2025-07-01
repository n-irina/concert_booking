<?php

namespace App\Controller\Api;

use App\Entity\Booking;
use App\Entity\Session;
use App\Entity\SeatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class BookingController extends AbstractController
{
    #[Route('/bookings/batch', name: 'api_bookings_batch', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function createBooking(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }
        if (!isset($data['items']) || !is_array($data['items'])) {
            return new JsonResponse(['error' => 'Invalid data'], 400);
        }
        $createdBookings = [];
        
        foreach ($data['items'] as $item) {
            $session = $em->getRepository(Session::class)->find($item['sessionId']);
            $seatType = $em->getRepository(SeatType::class)->findOneBy(['name' => $item['seatTypeName']]);
            if (!$session || !$seatType) {
                continue; // ignore invalid items
            }
            $booking = new Booking();
            $booking->setUser($user);
            $booking->setSession($session);
            $booking->setSeatType($seatType);
            $booking->setSeatCount($item['quantity']);
            $booking->setBookingDate(new \DateTime());
            $em->persist($booking);
            $createdBookings[] = $booking;
        }
        $em->flush();
        return $this->json($createdBookings, 201, [], ['groups' => ['booking:read']]);
    }
} 