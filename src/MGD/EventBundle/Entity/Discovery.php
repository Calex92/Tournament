<?php

namespace MGD\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discovery
 *
 * @ORM\Table(name="discovery")
 * @ORM\Entity(repositoryClass="MGD\EventBundle\Repository\DiscoveryRepository")
 */
class Discovery extends Event
{

}

