<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:23
 */

namespace MGD\EventBundle\Twig;


use MGD\EventBundle\Entity\Event;
use MGD\EventBundle\Entity\Team;
use MGD\EventBundle\Service\ApplicationChecker;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AppExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var ApplicationChecker
     */
    private $applicationChecker;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(Router $router, ApplicationChecker $applicationChecker, TokenStorage $tokenStorage)
    {

        $this->router = $router;
        $this->applicationChecker = $applicationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getRouteForEvent', array($this, 'getRouteForEvent')),
            new \Twig_SimpleFunction('isUserWithTeam', array($this, 'isUserWithTeam'))
        );
    }

    public function getRouteForEvent(Event $event) {
        return $this->router->generate($event->getRoute(), array("id" => $event->getId()));
    }

    public function isUserWithTeam(Team $team) {
        $user = $this->tokenStorage->getToken()->getUser();
        //I must do a strict comparison because the method returns sometimes an object
        return $this->applicationChecker->isAlreadyApplicant($user, $team) !== false;
    }
}
