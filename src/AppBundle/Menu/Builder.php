<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 04/05/2017
 * Time: 10:34
 */

namespace AppBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * Builder constructor.
     * @param FactoryInterface $factory
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $authorizationChecker)
    {
        $this->factory = $factory;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createMainMenu() {
        $menu = $this->factory->createItem("root");
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild("News", array("route" => "mgd_news_index"));
        $menu->addChild("Evénements", array("route" => "mgd_event_homepage"));


        //If the user is not logged
        if (!$this->authorizationChecker->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            $menu->addChild("Se connecter", array("route" => "fos_user_security_login"));
        } else{
            if ($this->authorizationChecker->isGranted("ROLE_ADMIN")) {
                //If the user is logged

                //The user needs to be an ADMIN to have access to the admin panel
                $menu->addChild("Administration", array(
                    "uri" => "#",
                    "label" => "Administration <i class='fa fa-caret-down'></i>",
                    "extras" => array("safe_label" => true)))
                    ->setAttribute("class", "dropdown")
                    ->setLinkAttributes(array("class" => "dropdown-toggle", "data-toggle" => "dropdown", "role" => "button", "aria-haspopup" => "true", "aria-expanded" => "false"))
                    ->setChildrenAttribute("class", "dropdown-menu");

                $menu["Administration"]->addChild("Utilisateurs", array("route" => "mgd_admin_user_homepage"));
                $menu["Administration"]->addChild("News", array("route" => "mgd_news_list"));
                $menu["Administration"]->addChild("Tournois", array("route" => "fos_user_security_login"));
            }
            $menu->addChild("Mon profil", array("route" => "fos_user_profile_show"));
            $menu->addChild("Se déconnecter", array("route" => "fos_user_security_logout"));
        }

        return $menu;
    }
}
