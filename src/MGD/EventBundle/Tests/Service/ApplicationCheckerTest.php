<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 09/08/2017
 * Time: 15:27
 */

namespace MGD\EventBundle\Tests\Service;

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

    /**
     * The user is connected and try to apply to a team and applied for another team for another game
     */
    /*public function testCanApplySecondTeamAnotherGame() {
        $user = new User();
        $game = new Game();
        $anotherGame = new Game();

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $anotherTeam = $this->createMock("MGD\EventBundle\Entity\Team");

        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament->expects($this->any())
            ->method("getId")
            ->willReturn(1);

        $anotherTournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament->expects($this->any())
            ->method("getId")
            ->willReturn(2);

        $team->expects($this->any())
            ->method("getTournament")
            ->willReturn($tournament);
        $anotherTeam->expects($this->any())
            ->method("getTournament")
            ->willReturn($anotherTournament);

        $tournament->expects($this->any())
            ->method("getGame")
            ->willReturn($game);
        $anotherTournament->expects($this->any())
            ->method("getGame")
            ->willReturn($anotherGame);

        $game->setName("TestGame");
        $anotherGame->setName("AnotherGame");

        $gamingProfile = new GamingProfile();
        $gamingProfile->setGame($game);
        $gamingProfile->setUsername("TestGameUsername");

        $anotherGamingProfile = new GamingProfile();
        $anotherGamingProfile->setGame($anotherGame);
        $anotherGamingProfile->setUsername("TestAnotherGameUsername");

        $user->setGamingProfiles(new ArrayCollection(array($gamingProfile, $anotherGamingProfile)));

        $user->addApplication($anotherTeam);
        $user->addTeam($anotherTeam);

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);


        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);
        //Here, we try to apply to a team
        $this->assertTrue($applicationChecker->canApply($user, $team));

    }*/
}
