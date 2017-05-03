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
     * @var int
     *
     * @ORM\Column(name="team_size", type="integer")
     */
    private $teamSize;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * Team constructor.
     * @param int $teamSize
     */
    public function __construct($teamSize)
    {
        $this->teamSize = $teamSize;
    }


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

    /**
     * @return int
     */
    public function getTeamSize()
    {
        return $this->teamSize;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
