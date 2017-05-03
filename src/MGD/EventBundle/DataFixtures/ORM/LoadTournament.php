<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 09:56
 */

namespace MGD\EventBundle\DataFixtures\ORM;


use AppBundle\DataFixtures\ORM\LoadObject;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\EventBundle\Entity\TournamentSolo;
use MGD\EventBundle\Entity\TournamentTeam;

class LoadTournament extends LoadObject
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tournament = new TournamentTeam();
        $tournament->setTitle("Tournoi League of Legends");
        $tournament->setDescription($this->getLoremIpsum(10));
        $tournament->setNumberParticipantMax(20);
        $tournament->setCreationDate(new \DateTime());
        $tournament->setStartDate(new \DateTime("+4d"));
        $tournament->setEndDate(new \DateTime("+5d"));
        $tournament->setCover("http://placehold.it/400x250");

        $manager->persist($tournament);


        $tournament = new TournamentSolo();
        $tournament->setTitle("Tournoi Hearthstone");
        $tournament->setDescription($this->getLoremIpsum(6));
        $tournament->setNumberParticipantMax(20);
        $tournament->setCreationDate(new \DateTime());
        $tournament->setStartDate(new \DateTime("+15d"));
        $tournament->setEndDate(new \DateTime("+18d"));
        $tournament->setCover("http://placehold.it/400x250");

        $manager->persist($tournament);

        $manager->flush();
    }
}
