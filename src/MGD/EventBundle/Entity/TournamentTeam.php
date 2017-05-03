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


}
