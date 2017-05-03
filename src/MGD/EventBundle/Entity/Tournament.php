<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\TournamentRepository")
 */
class Tournament extends Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="numberParticipantMax", type="integer")
     */
    private $numberParticipantMax;

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


}
