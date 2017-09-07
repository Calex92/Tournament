<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/04/2017
 * Time: 14:02
 */

namespace MGD\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction() {
        $users = $this->getDoctrine()->getRepository("MGDUserBundle:User")->findAll();

        return $this->render('MGDAdminBundle:User:index.html.twig', array(
            'users' => $users,
        ));
    }
}
