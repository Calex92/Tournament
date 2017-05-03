<?php

namespace MGD\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $events = $this->getDoctrine()->getRepository("MGDEventBundle:Event")->findAll();

        return $this->render('MGDEventBundle:Default:index.html.twig', array(
            "events"    => $events
        ));
    }
}
