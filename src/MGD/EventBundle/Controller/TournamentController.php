<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:16
 */

namespace MGD\EventBundle\Controller;


use MGD\EventBundle\Entity\TournamentSolo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TournamentController extends Controller
{
    public function viewAction($id) {
        if ($id > 0)
            $tournament = null;
        else
            $tournament = new TournamentSolo();

        return $this->render("MGDEventBundle:Tournament:view.html.twig", array(
            "tournament" => $tournament
        ));
    }
}
