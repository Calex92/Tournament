<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MGD\UserBundle\Entity\User;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\TeamRepository")
 */
class Team
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var TournamentTeam
     *
     * @ORM\ManyToOne(targetEntity="MGD\EventBundle\Entity\TournamentTeam", inversedBy="teams")
     */
    private $tournament;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="MGD\UserBundle\Entity\User", mappedBy="teams")
     */
    private $players;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TournamentTeam
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param TournamentTeam $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return User[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param User[] $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }


}

