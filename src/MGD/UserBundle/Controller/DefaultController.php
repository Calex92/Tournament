<?php

namespace MGD\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MGDUserBundle:Default:index.html.twig');
    }
}
