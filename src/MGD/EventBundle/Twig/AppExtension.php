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
use MGD\EventBundle\Entity\TournamentSolo;
use MGD\EventBundle\Entity\TournamentTeam;
use MGD\EventBundle\Service\ApplicationChecker;
use MGD\EventBundle\Service\TeamChecker;
use MGD\UserBundle\Entity\User;
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
    /**
     * @var TeamChecker
     */
    private $teamChecker;

    public function __construct(Router $router, ApplicationChecker $applicationChecker, TokenStorage $tokenStorage, TeamChecker $teamChecker)
    {

        $this->router = $router;
        $this->applicationChecker = $applicationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->teamChecker = $teamChecker;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getRouteForEvent', array($this, 'getRouteForEvent')),
            new \Twig_SimpleFunction('isUserWithTeam', array($this, 'isUserWithTeam')),
            new \Twig_SimpleFunction('isUserWithThisTeam', array($this, 'isUserWithThisTeam')),
            new \Twig_SimpleFunction('isUserInTournament', array($this, 'isUserInTournament')),
            new \Twig_SimpleFunction('isTeamDeletable', array($this, 'isTeamDeletable')),
            new \Twig_SimpleFunction('getTeamFromTournament', array($this, 'getTeamFromTournament'))
        );
    }

    public function getRouteForEvent(Event $event) {
        return $this->router->generate($event->getRoute(), array("id" => $event->getId()));
    }

    /**
     * Return true if the current user applied for a team in the same tournament than this team
     * @param Team $team
     * @return bool
     */
    public function isUserWithTeam(Team $team) {
        //I must do a strict comparison because the method returns sometimes an object
        return $this->applicationChecker->isAlreadyApplicant($this->tokenStorage->getToken()->getUser(), $team) !== false;
    }

    /**
     * Returns true if the current user applied for this team.
     * @param Team $team
     * @return bool
     */
    public function isUserWithThisTeam(Team $team) {
        return $this->applicationChecker->isUserWithThisTeam($this->tokenStorage->getToken()->getUser(), $team);
    }

    /**
     * Check if a team can be deleted by the current user or not
     * @param Team $team
     * @param User $user
     * @return bool
     */
    public function isTeamDeletable(Team $team, User $user) {
        return $this->teamChecker->isDeletable($team, $user);
    }

    /**
     * Return the team the user applied for. If he didn't applied yet, return null
     * @param TournamentTeam $tournamentTeam
     * @return Team|null
     */
    public function getTeamFromTournament(TournamentTeam $tournamentTeam) {
        foreach ($tournamentTeam->getTeams() as $team) {
            //If the user is just applicant
            if (in_array($team, $this->tokenStorage->getToken()->getUser()->getApplications()->toArray())) {
                return $team;
            }
            //If the user is a player
            if (in_array($team, $this->tokenStorage->getToken()->getUser()->getTeams()->toArray())) {
                return $team;
            }
            //If the user created the team
            if (in_array($team, $this->tokenStorage->getToken()->getUser()->getManagedTeam()->toArray())) {
                return $team;
            }
        }
        return null;
    }

    public function isUserInTournament(TournamentSolo $tournament) {
        return !in_array($this->tokenStorage->getToken()->getUser(), $tournament->getPlayers()->toArray());
    }
}
