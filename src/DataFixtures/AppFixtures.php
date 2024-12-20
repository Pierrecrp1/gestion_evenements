<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer des événements
        for ($i = 1; $i <= 5; $i++) {
            $event = new Event();
            $event->setName("Événement $i");
            $event->setDate(new \DateTime("+$i days"));
            $event->setLocation("Lieu $i");
            $event->setLatitude(48.8566 + mt_rand(-10, 10) / 100);
            $event->setLongitude(2.3522 + mt_rand(-10, 10) / 100);

            // Ajouter des participants à chaque événement
            for ($j = 1; $j <= 3; $j++) {
                $participant = new Participant();
                $participant->setName("Participant $j de l'Événement $i");
                $participant->setEmail("participant$j.event$i@example.com");
                $participant->setEvent($event);

                $manager->persist($participant);
            }

            $manager->persist($event);
        }

        // Sauvegarder dans la base de données
        $manager->flush();
    }
}
