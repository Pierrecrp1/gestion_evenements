<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        $upcomingEvents = $eventRepository->createQueryBuilder('e')
            ->where('e.date >= :today')
            ->setParameter('today', new \DateTime())
            ->orderBy('e.date', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}