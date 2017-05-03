<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:54
 */

namespace MGD\EventBundle\Controller;


use MGD\EventBundle\Entity\Discovery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiscoveryController extends Controller
{
    public function viewAction(Discovery $discovery) {
        return $this->render("@MGDEvent/Discovery/view.html.twig", array(
            "discovery" => $discovery
        ));
    }
}