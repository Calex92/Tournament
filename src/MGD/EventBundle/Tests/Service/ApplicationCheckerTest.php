<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/08/2017
 * Time: 15:27
 */

namespace MGD\EventBundle\Tests\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MGD\EventBundle\Entity\Game;
use MGD\EventBundle\Service\ApplicationChecker;
use MGD\EventBundle\Service\TeamChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ApplicationCheckerTest extends TestCase
{
    public function testCanApplyNoUsername()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament->method("getGame")->willReturn(new Game());

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getTournament")->willReturn($tournament);

        //Here, we try to apply to a team
        $this->assertContains("Vous devez avoir un nom d'utilisateur pour pouvoir vous inscrire", $applicationChecker->canApply($user, $team));
    }

    public function testCanApplyIsAlreadyApplicant()
    {
        $gamingProfile = $this->createMock("MGD\EventBundle\Entity\Team");

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);
        $teamChecker->method("isAlreadyApplicant")->willReturn($gamingProfile);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user->method("getGamingUsername")->willReturn("Hello");

        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament->method("getGame")->willReturn(new Game());

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getTournament")->willReturn($tournament);

        //Here, we try to apply to a team
        $this->assertContains("Vous avez déjà postulé pour une équipe pour ce tournoi", $applicationChecker->canApply($user, $team));
    }

    public function testCanApplyWhenAllIsOk()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);
        $teamChecker->method("isAlreadyApplicant")->willReturn(false);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user->method("getGamingUsername")->willReturn("Hello");

        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament->method("getGame")->willReturn(new Game());

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getTournament")->willReturn($tournament);

        $this->assertTrue($applicationChecker->canApply($user, $team));
    }

    public function testCanQuitIsManager()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team2 = $this->createMock("MGD\EventBundle\Entity\Team");
        $team3 = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array($team, $team2, $team3)));

        $this->assertFalse($applicationChecker->canQuit($user, $team));
    }

    public function testCanQuitIsNotManager()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team2 = $this->createMock("MGD\EventBundle\Entity\Team");
        $team3 = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array($team2, $team3)));

        $this->assertTrue($applicationChecker->canQuit($user, $team));
    }

    public function testIsUserWithThisTeamIsInApplicants()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user2 = $this->createMock("MGD\UserBundle\Entity\User");
        $user3 = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getApplicants")->willReturn(new ArrayCollection(array($user, $user2, $user3)));
        $team->method("getPlayingUsers")->willReturn(new ArrayCollection(array($user2, $user3)));

        $this->assertTrue($applicationChecker->isUserWithThisTeam($user, $team));
    }

    public function testIsUserWithThisTeamIsNotInApplicants()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user2 = $this->createMock("MGD\UserBundle\Entity\User");
        $user3 = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getApplicants")->willReturn(new ArrayCollection(array($user2, $user3)));
        $team->method("getPlayingUsers")->willReturn(new ArrayCollection(array($user2, $user3)));

        $this->assertFalse($applicationChecker->isUserWithThisTeam($user, $team));
    }

    public function testIsUserWithThisTeamIsInPlayingUsers()
    {
        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);

        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user2 = $this->createMock("MGD\UserBundle\Entity\User");
        $user3 = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getApplicants")->willReturn(new ArrayCollection(array($user2, $user3)));
        $team->method("getPlayingUsers")->willReturn(new ArrayCollection(array($user, $user2, $user3)));

        $this->assertTrue($applicationChecker->isUserWithThisTeam($user, $team));
    }
}
