<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:16
 */

namespace MGD\EventBundle\Controller;


use MGD\EventBundle\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TournamentController extends Controller
{
    public function viewAction(Tournament $tournament) {
        return $this->render("MGDEventBundle:Tournament:view.html.twig", array(
            "tournament" => $tournament
        ));
    }
}