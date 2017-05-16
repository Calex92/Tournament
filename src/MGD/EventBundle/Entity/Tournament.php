<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity()
 * @DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\InheritanceType("JOINED")
 */
abstract class Tournament extends Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="numberParticipantMax", type="integer")
     */
    private $numberParticipantMax;

    /**
     * @var Game
     *
     * @ORM\ManyToOne(targetEntity="MGD\EventBundle\Entity\Game")
     */
    private $game;

    /**
     * @return mixed
     */
    public function getNumberParticipantMax()
    {
        return $this->numberParticipantMax;
    }

    /**
     * @param mixed $numberParticipantMax
     */
    public function setNumberParticipantMax($numberParticipantMax)
    {
        $this->numberParticipantMax = $numberParticipantMax;
    }


    /**
     * @return string
     */
    public function getRoute()
    {
        return "mdg_tournament_view";
    }

    public abstract function getTemplateName();

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param Game $game
     * @return $this
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }
}
