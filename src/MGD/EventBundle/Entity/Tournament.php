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
}
