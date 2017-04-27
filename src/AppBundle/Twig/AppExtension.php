<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/04/2017
 * Time: 11:26
 */

namespace AppBundle\Twig;


use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AppExtension extends \Twig_Extension
{
    private $authorizationChecker;
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getMenu', array($this, 'getMenu'))
        );
    }

    public function getMenu() {
        $menus = array();

        $menus[] = array("route"=> "mgd_news_homepage",
                    "label"     => "News");

        $menus[] = array("route"=> "mgd_event_homepage",
                    "label"     => "Evénements");

        //If the user is not logged
        if (!$this->authorizationChecker->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            $menus[] = array("route" => "fos_user_security_login",
                "label" => "Se connecter");
        }
        //If the user is logged
        else {
            $menus[] = array("route" => "mgd_admin_user_homepage",
                "label" => "Administration",
                "routes"    => array("mgd_admin_user_homepage", "mgd_admin_user_homepage", "mgd_admin_user_homepage"),
                "children" => array(
                    array("route" => "mgd_admin_user_homepage",
                        "label" => "Utilisateurs"),
                    array("route" => "mgd_admin_user_homepage",
                        "label" => "News"),
                    array("route" => "mgd_admin_user_homepage",
                        "label" => "Tournois")
                ));

            $menus[] = array("route" => "fos_user_security_logout",
                "label" => "Se déconnecter");
        }

        return $menus;
    }
}
