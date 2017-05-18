<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MGD\UserBundle\Entity\User;

/**
 * UserGame
 *
 * @ORM\Table(name="gaming_profile")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\GamingProfileRepository")
 */
class GamingProfile
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MGD\UserBundle\Entity\User", inversedBy="gamingProfiles")
     */
    private $user;

    /**
     * @var Game
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MGD\EventBundle\Entity\Game", inversedBy="gamingProfiles")
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;


    /**
     * Set username
     *
     * @param string $username
     *
     * @return GamingProfile
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

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

