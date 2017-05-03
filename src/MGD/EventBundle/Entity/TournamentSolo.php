<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MGD\UserBundle\Entity\User;

/**
 * TournamentSolo
 *
 * @ORM\Table(name="tournament_solo")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\TournamentSoloRepository")
 */
class TournamentSolo extends Tournament
{
    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="MGD\UserBundle\Entity\User", mappedBy="tournamentSolo")
     */
    private $players;

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

    public function getTemplateName()
    {
        return "view_solo.html.twig";
    }
}
