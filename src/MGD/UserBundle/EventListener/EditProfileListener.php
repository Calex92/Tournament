<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 18/05/2017
 * Time: 17:12
 */

namespace MGD\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use MGD\EventBundle\Entity\GamingProfile;
use MGD\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class EditProfileListener implements EventSubscriberInterface
{

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(FOSUserEvents::PROFILE_EDIT_SUCCESS => "removeGamingEmpty");
    }

    /**
     * This methods is used to remove the empty GamingProfiles from the user
     */
    public function removeGamingEmpty()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $idToRemove = array();

        //For each GamingProfile, we need to set the user as the owner of this relationship, if we don't, Doctrine doesn't know
        //the owner
        foreach ($user->getGamingProfiles() as $gamingProfile) {
            /** @var GamingProfile $gamingProfile */
            $gamingProfile->setUser($user);
        }

        //Then, we look if the user filled the username.
        for ($i = 0; $i < count($user->getGamingProfiles()) ; $i++) {
            $gamingProfile = $user->getGamingProfiles()->get($i);
            if (!isset($gamingProfile) || is_null($gamingProfile) || is_null($gamingProfile->getUsername()) || $gamingProfile->getUsername() =="") {
                $idToRemove[] = $i;
            }
        }
        //If the user didn't fill the infos, we have to remove them
        foreach ($idToRemove as $id) {
            $user->getGamingProfiles()->remove($id);
        }
    }
}
