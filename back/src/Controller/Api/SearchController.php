<?php

namespace App\Controller\Api;

use App\Repository\ArtistRepository;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/api/search', name: 'api_search', methods: ['GET'])]
    public function search(
        Request $request,
        EventRepository $eventRepository,
        ArtistRepository $artistRepository,
        CategoryRepository $categoryRepository,
        HallRepository $hallRepository,
    ): JsonResponse {
         // Retrieve the search query (?q=...)
        $query = $request->query->get('q', '');

        // Return empty results if the query is blank
        if (empty($query)) {
            return $this->json([
                'events' => [],
                'artists' => [],
                'categories' => [],
                'halls' => [],
            ]);
        }

        // Perform a case-insensitive search on each entity's relevant field
        $events = $eventRepository->createQueryBuilder('e')
            ->where('LOWER(e.name) LIKE :q')
            ->setParameter('q', '%' . strtolower($query) . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $artists = $artistRepository->createQueryBuilder('a')
            ->where('LOWER(a.nickname) LIKE :q')
            ->setParameter('q', '%' . strtolower($query) . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $categories = $categoryRepository->createQueryBuilder('c')
            ->where('LOWER(c.name) LIKE :q')
            ->setParameter('q', '%' . strtolower($query) . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $halls = $hallRepository->createQueryBuilder('h')
            ->where('LOWER(h.name) LIKE :q')
            ->setParameter('q', '%' . strtolower($query) . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        // Format the results to return minimal useful data
        $data = [
            'events' => array_map(fn($e) => [
                'id' => $e->getId(),
                'name' => $e->getName(),
            ], $events),

            'artists' => array_map(fn($a) => [
                'id' => $a->getId(),
                'nickname' => $a->getNickname(),
            ], $artists),

            'categories' => array_map(fn($c) => [
                'id' => $c->getId(),
                'name' => $c->getName(),
            ], $categories),

            'halls' => array_map(fn($h) => [
                'id' => $h->getId(),
                'name' => $h->getName(),
            ], $halls),
        ];

        return $this->json($data);
    }
}
