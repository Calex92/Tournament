<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/08/2017
 * Time: 17:04
 */

namespace MGD\EventBundle\Service;


use MGD\EventBundle\Entity\Team;
use MGD\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class TeamChecker
{

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Check if a team can be deleted by the user passed in argument
     *
     * @param Team $team
     * @param User $user
     * @return bool
     */
    public function isDeletable(Team $team, User $user)
    {
        if ($this->authorizationChecker->isGranted("ROLE_ADMIN")) {
            //This is an admin, he can do what he wants!
            return true;
        }

        if ($user->getId() !== $team->getLeader()->getId()) {
            //The user is not admin and he's not the leader of the team
            return false;
        }

        if ($team->isPaid()) {
            //The user is not admin and the team has pay, so it's not possible anymore to delete it
            return false;
        } else {
            //the team isn't validated, we can delete it
            return true;
        }
    }
}
