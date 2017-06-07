<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 31/05/2017
 * Time: 17:20
 */

namespace MGD\EventBundle\Service;


use MGD\EventBundle\Entity\Team;
use MGD\UserBundle\Entity\User;
use Symfony\Component\Routing\Router;

class ApplicationChecker
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * This methods check if the user can apply to the team, it search if he have a username for the game and if he doens't already applied for another team in the same tournament
     * @param User $user
     * @param Team $team
     * @return bool|string
     */
    public function canApply(User $user, Team $team) {
        if ($user->getGamingUsername($team->getTournament()->getGame()) === null) {
            return "Vous devez avoir un nom d'utilisateur pour pouvoir vous inscrire, renseignez le dans \"Mon profil\"";
        } else if (false !== $teamAlreadyIn = $this->isAlreadyApplicant($user, $team)) {
            return "Vous avez déjà postulé pour une équipe pour ce tournoi : 
            <a href=\"".$this->router->generate("mgd_team_show", array("id" => $teamAlreadyIn->getId()))."\">".htmlspecialchars($teamAlreadyIn->getName())."</a>";
        }
        return true;
    }

    /**
     * This method search if the user is already in a team for the same tournament than the one passed in argument
     * @param User $user
     * @param Team $team
     * @return bool|Team|mixed
     */
    public function isAlreadyApplicant(User $user, Team $team) {
        $teams = $user->getApplications();
        foreach ($teams as $userTeam) {
            /** @var Team $userTeam */
            if ($userTeam->getTournament()->getId() === $team->getTournament()->getId()) {
                return $userTeam;
            }
        }
        return false;
    }
}