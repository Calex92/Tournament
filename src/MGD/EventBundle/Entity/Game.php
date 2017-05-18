<?php

namespace MGD\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\GameRepository")
 */
class Game
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var  ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MGD\EventBundle\Entity\GamingProfile", mappedBy="game", cascade={"remove"})
     */
    private $gamingProfiles;


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
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getGamingProfiles()
    {
        return $this->gamingProfiles;
    }

    /**
     * @param ArrayCollection $gamingProfiles
     * @return $this
     */
    public function setGamingProfiles($gamingProfiles)
    {
        $this->gamingProfiles = $gamingProfiles;
        return $this;
    }
}

