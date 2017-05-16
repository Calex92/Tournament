<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentTeam
 *
 * @ORM\Table(name="tournament_team")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\TournamentTeamRepository")
 */
class TournamentTeam extends Tournament
{
    /**
     * @var Team[]
     *
     * @ORM\OneToMany(targetEntity="MGD\EventBundle\Entity\Team", mappedBy="tournament")
     */
    private $teams;

    /**
     * @var int
     *
     * @ORM\Column(name="team_size", type="integer", nullable=false)
     */
    private $teamSize;
    /**
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    public function getTemplateName()
    {
        return "view_team.html.twig";
    }

    /**
     * @return int
     */
    public function getTeamSize()
    {
        return $this->teamSize;
    }

    /**
     * @param int $teamSize
     * @return $this
     */
    public function setTeamSize($teamSize)
    {
        $this->teamSize = $teamSize;
        return $this;
    }
}
