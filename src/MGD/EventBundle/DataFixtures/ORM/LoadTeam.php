<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 17/05/2017
 * Time: 17:45
 */

namespace MGD\EventBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\EventBundle\Entity\Team;
use MGD\EventBundle\Entity\TournamentTeam;
use MGD\UserBundle\Entity\User;

class LoadTeam extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lastnames = array(
            "leader1"   => "Leader1",
            "leader2"   => "Leader2",
            "leader3"   => "Leader3",
            "Player11"  => "Player11",
            "Player12"  => "Player12",
            "Player13"  => "Player13",
            "Player14"  => "Player14",
            "Player21"  => "Player21",
            "Player22"  => "Player22",
            "Applicant15"  => "Applicant15",
            "Applicant16"  => "Applicant16",
            "Applicant23"  => "Applicant23",
            "Applicant24"  => "Applicant24",
            "Applicant25"  => "Applicant25",
            "Applicant26"  => "Applicant26",
            "Applicant31"  => "Applicant31",
            "Applicant32"  => "Applicant32",
        );

        $titles = array(
            "Tournoi League of Legends",
            "Tournoi CS:GO",
            "Tournoi Overwatch"
        );

        $tournaments = array(
            $titles[0],
            $titles[0],
            $titles[0]
        );

        $leaders = array(
            $lastnames["leader1"],
            $lastnames["leader2"],
            $lastnames["leader3"]
        );

        $players = array(
            array(
                $lastnames["Player11"],
                $lastnames["Player12"],
                $lastnames["Player13"],
                $lastnames["Player14"]
            ),
            array(
                $lastnames["Player21"],
                $lastnames["Player22"]
            ),
            array()
        );

        $applicants = array(
            array(
                $lastnames["Applicant15"],
                $lastnames["Applicant16"],
            ),
            array(
                $lastnames["Applicant23"],
                $lastnames["Applicant24"],
                $lastnames["Applicant25"],
                $lastnames["Applicant26"],
            ),
            array(
                $lastnames["Applicant31"],
                $lastnames["Applicant32"],
            )
        );

        $teamNames = array(
            "L'équipe avec des accents!",
            "Equipe2",
            "Equipe3"
        );

        for ($i = 0; $i < count($leaders); $i++) {
            $team = new Team();
            /** @var User $leader */
            $leader = $this->getReference($leaders[$i]);
            $team->setLeader($leader);

            foreach ($players[$i] as $playerReference) {
                /** @var User $player */
                $player = $this->getReference($playerReference);
                $team->addPlayer($player);
                $team->addApplicant($player);
            }

            foreach ($applicants[$i] as $applicantReference) {
                /** @var User $applicant */
                $applicant = $this->getReference($applicantReference);
                $team->addApplicant($applicant);
            }

            $team->setName($teamNames[$i]);

            /** @var TournamentTeam $tournament */
            $tournament = $this->getReference($tournaments[$i]);
            $team->setTournament($tournament);

            $manager->persist($team);
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
        return 4;
    }
}