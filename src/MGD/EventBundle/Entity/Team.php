<?php

namespace MGD\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MGD\UserBundle\Entity\User;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MGD\UserBundle\Entity\User", inversedBy="teams")
     */
    private $players;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MGD\UserBundle\Entity\User", inversedBy="applications").
     * @ORM\JoinTable(name="team_user_application",
     *     joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $applicants;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="MGD\UserBundle\Entity\User", inversedBy="managedTeam")
     */
    private $leader;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_paid", type="boolean", )
     */
    private $paid = false;

    /**
     * Team constructor.
     */
    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->applicants = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    public function getPlayingUsers()
    {
        $users = new ArrayCollection($this->players->toArray());
        $users->add($this->leader);

        return $users;
    }

    /**
     * @param ArrayCollection[User] $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
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

    /**
     * @return User
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * @param User $leader
     * @return $this
     */
    public function setLeader($leader)
    {
        $this->leader = $leader;
        return $this;
    }

    public function addPlayer(User $player) {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->addTeam($this);
        }
        return $this;
    }

    public function removePlayer(User $player) {
        $this->players->removeElement($player);
        $player->removeTeam($this);

        return $this;
    }

    public function addApplicant(User $player) {
        if (!$this->applicants->contains($player)) {
            $this->applicants->add($player);
            $player->addTeam($this);
        }
        return $this;
    }

    public function removeApplicant(User $player) {
        $this->applicants->removeElement($player);
        $player->removeTeam($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * @param mixed $applicants
     * @return $this
     */
    public function setApplicants($applicants)
    {
        $this->applicants = $applicants;
        return $this;
    }

    /**
     * @Assert\Callback()
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context) {
        if (count($this->players) > ($this->getTournament()->getTeamSize()-1)) {
            $context->buildViolation("Une équipe ne peut être composée que de ".$this->getTournament()->getTeamSize().
                " joueurs (le chef d'équipe + les ".($this->getTournament()->getTeamSize()-1)." joueurs)")
                ->atPath("players")
                ->addViolation();
        }
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param boolean $paid
     * @return $this
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
        return $this;
    }


}
