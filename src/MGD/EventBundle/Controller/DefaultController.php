<?php

namespace MGD\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $events = array(
            array(
                "image"     => "http://placehold.it/400x250",
                "title"     => "Texte de présentation long",
                "route"     => "mgd_event_homepage"
            ),
            array(
                "image"     => "http://placehold.it/400x250",
                "title"     => "Texte de présentation court",
                "route"     => "mgd_event_homepage"
            ),
            array(
                "image"     => "http://placehold.it/400x250",
                "title"     => "Texte de présentation très très long",
                "route"     => "mgd_event_homepage"
            ),
        );
        return $this->render('MGDEventBundle:Default:index.html.twig', array(
            "events"    => $events
        ));
    }
}
