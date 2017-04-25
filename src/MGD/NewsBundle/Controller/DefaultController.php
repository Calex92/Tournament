<?php

namespace MGD\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MGDNewsBundle:Default:index.html.twig');
    }
}
