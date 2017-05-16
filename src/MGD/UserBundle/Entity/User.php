<?php

namespace MGD\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use MGD\EventBundle\Entity\Event;
use MGD\EventBundle\Entity\Team;
use MGD\EventBundle\Entity\TournamentSolo;
use MGD\NewsBundle\Entity\News;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MGD\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string")
     */
    private $lastname;

    /**
     * @var Event[]
     *
     * @ORM\ManyToMany(targetEntity="MGD\EventBundle\Entity\Event", inversedBy="responsibles")
     */
    private $managedEvents;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MGD\EventBundle\Entity\Team", mappedBy="players")
     */
    private $teams;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MGD\EventBundle\Entity\Team", mappedBy="applicants")
     */
    private $applications;

    /**
     * @var TournamentSolo[]
     *
     * @ORM\ManyToMany(targetEntity="MGD\EventBundle\Entity\TournamentSolo", inversedBy="players")
     */
    private $tournamentSolo;

    /**
     * @var News[]
     *
     * @ORM\OneToMany(targetEntity="MGD\NewsBundle\Entity\News", mappedBy="author", cascade={"remove"})
     */
    private $news;

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
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return Event[]
     */
    public function getManagedEvents()
    {
        return $this->managedEvents;
    }

    /**
     * @param Event[] $managedEvents
     */
    public function setManagedEvents($managedEvents)
    {
        $this->managedEvents = $managedEvents;
    }

    /**
     * @return ArrayCollection
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

    /**
     * @return TournamentSolo[]
     */
    public function getTournamentSolo()
    {
        return $this->tournamentSolo;
    }

    /**
     * @param TournamentSolo[] $tournamentSolo
     */
    public function setTournamentSolo($tournamentSolo)
    {
        $this->tournamentSolo = $tournamentSolo;
    }

    /**
     * @return News[]
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param News[] $news
     */
    public function setNews($news)
    {
        $this->news = $news;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->username = $email;

        return $this;
    }

    public function addTeam(Team $team)
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }
        return $this;
    }

    public function removeTeam(Team $team)
    {
        $this->teams->removeElement($team);
    }

    public function addApplication(Team $team)
    {
        if (!$this->applications->contains($team)) {
            $this->applications->add($team);
        }
        return $this;
    }

    public function removeApplication(Team $team)
    {
        $this->applications->removeElement($team);
    }

    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param ArrayCollection $applications
     * @return $this
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;
        return $this;
    }
}

