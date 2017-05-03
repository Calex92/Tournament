<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:23
 */

namespace MGD\EventBundle\Twig;


use MGD\EventBundle\Entity\Event;
use Symfony\Component\Routing\Router;

class AppExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getRouteForEvent', array($this, 'getRouteForEvent'))
        );
    }

    public function getRouteForEvent(Event $event) {
        return $this->router->generate($event->getRoute(), array("id" => $event->getId()));
    }
}
