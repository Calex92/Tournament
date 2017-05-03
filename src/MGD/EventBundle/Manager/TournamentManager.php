<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 14:55
 */

namespace MGD\EventBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;

class TournamentManager
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * This method returns either a solo tournament or a team tournament
     * @param $id
     * @return \MGD\EventBundle\Entity\TournamentSolo|\MGD\EventBundle\Entity\TournamentTeam
     */
    public function getTournament($id) {


        if (($tournament = $this->em->getRepository("MGDEventBundle:TournamentSolo")->find($id)) === null) {
            $tournament = $this->em->getRepository("MGDEventBundle:TournamentTeam")->find($id);
        }
        if ($tournament === null) {
            throw new Exception("Tournament no found");
        }
        return $tournament;
    }
}
