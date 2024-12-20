<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/events/{eventId}/participants', name: 'participant_')]
class ParticipantController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function addParticipant(
        int $eventId,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $event = $entityManager->getRepository(Event::class)->find($eventId);

        if (!$event) {
            throw $this->createNotFoundException('Event not found.');
        }

        $participant = new Participant();
        $participant->setEvent($event);

        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('event_view', ['id' => $eventId]);
        }

        return $this->render('participant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

