<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MGD\UserBundle\Entity\User;

/**
 * Event
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\Table(name="event")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
abstract class Event
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="MGD\UserBundle\Entity\User", mappedBy="managedEvents")
     *
     */
    private $responsibles;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string")
     */
    private $cover;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_publication_date", type="datetime")
     */
    private $startPublicationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_publication_date", type="datetime")
     */
    private $endPublicationDate;

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
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Event
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return $this
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return User[]
     */
    public function getResponsibles()
    {
        return $this->responsibles;
    }

    /**
     * @param User[] $responsibles
     * @return $this
     */
    public function setResponsibles($responsibles)
    {
        $this->responsibles = $responsibles;
        return $this;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     * @return $this
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartPublicationDate()
    {
        return $this->startPublicationDate;
    }

    /**
     * @param \DateTime $startPublicationDate
     * @return $this
     */
    public function setStartPublicationDate($startPublicationDate)
    {
        $this->startPublicationDate = $startPublicationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndPublicationDate()
    {
        return $this->endPublicationDate;
    }

    /**
     * @param \DateTime $endPublicationDate
     * @return $this
     */
    public function setEndPublicationDate($endPublicationDate)
    {
        $this->endPublicationDate = $endPublicationDate;
        return $this;
    }

    abstract public function getRoute();
}

