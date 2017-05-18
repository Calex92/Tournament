<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 09:56
 */

namespace MGD\EventBundle\DataFixtures\ORM;


use AppBundle\DataFixtures\ORM\LoadObject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\EventBundle\Entity\Game;
use MGD\EventBundle\Entity\TournamentTeam;

class LoadTournamentTeam extends LoadObject implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $gamesNames = ["League of Legends", "Hearthstone", "CS:GO", "Pokemon", "Clash Royale", "Overwatch"];
        $gamesId = array(
            $gamesNames[0],
            $gamesNames[2],
            $gamesNames[5]
        );

        $titles = array(
            "Tournoi League of Legends",
            "Tournoi CS:GO",
            "Tournoi Overwatch"
        );

        $descriptions = array(
            $this->getLoremIpsum(5),
            $this->getLoremIpsum(10),
            $this->getLoremIpsum(15)
        );

        $startPublicationDates = array(
            new \DateTime("2017-06-10"),
            new \DateTime("2017-04-10"),
            new \DateTime("2017-04-20")
        );

        $endPublicationDates = array(
            new \DateTime("2017-07-10"),
            new \DateTime("2017-08-10"),
            new \DateTime("2017-05-20")
        );

        $startDatesTimes = array(
            new \DateTime("2017-06-10 08:00:00"),
            new \DateTime("2017-05-05 07:30:00"),
            new \DateTime("2017-04-25 10:00:00")
        );

        $endDatesTimes = array(
            new \DateTime("2017-06-10 18:00:00"),
            new \DateTime("2017-05-05 12:00:00"),
            new \DateTime("2017-04-26 10:00:00")
        );

        $covers = array(
            "http://placehold.it/400x250",
            "http://placehold.it/400x250",
            "http://placehold.it/400x250"
        );

        $responsibleNames = array(
            array("Doe"),
            array("Fontenelle"),
            array("Doe", "Fontenelle")
        );

        $maxParticipants = array(
            80,
            60,
            40
        );

        $teamSizes = array(
            5,
            5,
            3
        );

        for ($i = 0 ; $i < count($titles) ; $i++) {
            $tournament = new TournamentTeam();
            $tournament->setTitle($titles[$i])
                ->setDescription($descriptions[$i])
                ->setCreationDate(new \DateTime())
                ->setStartDate($startDatesTimes[$i])
                ->setStartPublicationDate($startPublicationDates[$i])
                ->setEndDate($endDatesTimes[$i])
                ->setEndPublicationDate($endPublicationDates[$i])
                ->setCover($covers[$i]);

            $responsibles = array();
            foreach ($responsibleNames[$i] as $responsibleName) {
                $responsibles[] = $this->getReference($responsibleName);
            }
            $tournament->setResponsibles($responsibles);
            $tournament->setNumberParticipantMax($maxParticipants[$i]);

            /** @var Game $game */
            $game = $this->getReference($gamesId[$i]);
            $tournament->setGame($game);

            $tournament->setTeamSize($teamSizes[$i]);

            $manager->persist($tournament);

            $this->setReference($titles[$i], $tournament);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
