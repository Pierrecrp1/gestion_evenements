<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Service\DistanceCalculator;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/events', name: 'event_')]
class EventController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function listEvents(Request $request, EventRepository $eventRepository, DistanceCalculator $distanceCalculator): Response
    {
        $events = $eventRepository->findAll();

        $userLat = $request->query->get('lat');
        $userLon = $request->query->get('lon');

        // Calcul des distances si les coordonnées utilisateur sont fournies
        $eventsWithDistance = [];
        foreach ($events as $event) {
            $distance = null;
            if ($userLat && $userLon && $event->getLatitude() && $event->getLongitude()) {
                $distance = $distanceCalculator->calculateDistance($userLat, $userLon, $event->getLatitude(), $event->getLongitude());
            }

            $eventsWithDistance[] = [
                'event' => $event,
                'distance' => $distance,
            ];
        }

        return $this->render('event/index.html.twig', [
            'events' => $eventsWithDistance,
            'userLat' => $userLat,
            'userLon' => $userLon,
        ]);
    }

    #[Route('/{id}', name: 'view', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function viewEvent(Event $event): Response
    {
        return $this->render('event/view.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/distance', name: 'distance', methods: ['GET'])]
    public function calculateDistanceToEvent(
        Event $event,
        Request $request,
        DistanceCalculator $distanceCalculator
    ): Response {
        // Récupérer les coordonnées de l'utilisateur depuis la requête
        $userLat = $request->query->get('lat');
        $userLon = $request->query->get('lon');

        if (!$userLat || !$userLon) {
            return $this->json(['error' => 'Latitude and longitude are required'], 400);
        }

        // Récupérer les coordonnées de l'événement
        $eventLat = $event->getLatitude();
        $eventLon = $event->getLongitude();

        // Calculer la distance
        $distance = $distanceCalculator->calculateDistance($userLat, $userLon, $eventLat, $eventLon);

        return $this->json([
            'event' => $event->getName(),
            'location' => $event->getLocation(),
            'distance_km' => $distance,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function createEvent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Événement créé avec succès !');
            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}