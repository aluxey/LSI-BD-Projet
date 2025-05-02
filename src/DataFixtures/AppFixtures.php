<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Entity\Promo;
use App\Entity\Projet;
use App\Entity\Evenement;
use App\Entity\ForumProjet;
use App\Entity\ForumEvenement;
use App\Entity\MessageProjet;
use App\Entity\MessageEvenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Créer 3 promos
        $promos = [];
        for ($i = 0; $i < 3; $i++) {
            $promo = new Promo();
            $promo->setNom("Promo " . ($i + 1));
            $manager->persist($promo);
            $promos[] = $promo;
        }

        // Créer 10 membres liés à des promos
        for ($i = 0; $i < 10; $i++) {
            $membre = new Membre();
            $membre->setNom($faker->lastName());
            $membre->setPrenom($faker->firstName());
            $membre->setRole($faker->randomElement(['Admin', 'Membre']));
            $membre->setEmail($faker->email());
            $membre->setPassword(password_hash('test1234', PASSWORD_DEFAULT)); // ✅
            $membre->setPromo($faker->randomElement($promos));
            $manager->persist($membre);
            $membres[] = $membre;
        }



        // Créer 5 projets
        $projets = [];
        for ($i = 0; $i < 5; $i++) {
            $projet = new Projet();
            $projet->setNom("Projet " . ($i + 1));
            $projet->setDescription($faker->sentence());
            $projet->setTheme($faker->word());
            $projet->setType($faker->randomElement(['Groupe', 'Solo']));
            $projet->setDateEvent($faker->dateTimeBetween('-1 year', '+1 year'));
            $manager->persist($projet);
            $projets[] = $projet;
        }

        // Créer les forums pour chaque projet
        $forumsProjet = [];
        foreach ($projets as $projet) {
            $forumProjet = new ForumProjet();
            $forumProjet->setTitre("Forum du " . $projet->getNom());
            $forumProjet->setProjet($projet);
            $manager->persist($forumProjet);
            $forumsProjet[] = $forumProjet;
        }

        // Créer 4 événements et leurs forums
        $evenements = [];
        $forumsEvenement = [];
        for ($i = 0; $i < 4; $i++) {
            $event = new Evenement();
            $event->setNom("Événement " . ($i + 1));
            $event->setDescription($faker->sentence());
            $event->setDateEvent($faker->dateTimeBetween('-6 months', '+6 months'));
            $manager->persist($event);
            $evenements[] = $event;

            $forumEvent = new ForumEvenement();
            $forumEvent->setTitre("Forum de " . $event->getNom());
            $forumEvent->setEvenement($event);
            $event->setForumEvenement($forumEvent); // lien bidirectionnel
            $manager->persist($forumEvent);
            $forumsEvenement[] = $forumEvent;
        }

        // Ajouter un message à un forum projet pour chaque membre
        foreach ($membres as $membre) {
            $message = new MessageProjet();
            $message->setMessage($faker->sentence());
            $message->setDateMessage($faker->dateTimeBetween('-3 months'));
            $message->setMembre($membre);
            $message->setForumProjet($faker->randomElement($forumsProjet));
            $manager->persist($message);
        }

        // Ajouter un message à un forum événement pour chaque membre
        foreach ($membres as $membre) {
            $message = new MessageEvenement();
            $message->setMessage($faker->sentence());
            $message->setDateMessage($faker->dateTimeBetween('-3 months'));
            $message->setMembre($membre);
            $message->setForumEvenement($faker->randomElement($forumsEvenement)); // méthode exacte
            $manager->persist($message);
        }

        $manager->flush();
    }
}
