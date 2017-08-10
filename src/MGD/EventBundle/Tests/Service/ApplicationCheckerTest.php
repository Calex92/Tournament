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
use MGD\EventBundle\Entity\GamingProfile;
use MGD\EventBundle\Entity\Team;
use MGD\EventBundle\Entity\TournamentTeam;
use MGD\EventBundle\Service\ApplicationChecker;
use MGD\EventBundle\Service\TeamChecker;
use MGD\UserBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ApplicationCheckerTest extends TestCase
{
    /**
     * The user doesn't have a username so he can't apply
     */
    public function testCanApplyNoUsername() {
        $user = new User();
        $game = new Game();
        $team = new Team();
        $tournament = new TournamentTeam();

        $team->setTournament($tournament);
        $tournament->setGame($game);
        $game->setName("TestGame");

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationChecker::class);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);
        //Here, we just don't have any gaming profile
        $this->assertEquals("Vous devez avoir un nom d'utilisateur pour pouvoir vous inscrire, renseignez le dans \"Mon profil\"", $applicationChecker->canApply($user, $team));


        $otherGame = new Game();
        $otherGame->setName("OtherTestGame");
        $gamingProfile = new GamingProfile();
        $gamingProfile->setGame($otherGame);
        $gamingProfile->setUsername("OtherTestGameUsername");
        $user->setGamingProfiles(new ArrayCollection(array($gamingProfile)));

        $thirdGame = new Game();
        $thirdGame->setName("OtherTestGame");
        $anotherProfile = new GamingProfile();
        $anotherProfile->setGame($thirdGame);
        $anotherProfile->setUsername("OtherTestGameUsername");
        $user->setGamingProfiles(new ArrayCollection(array($anotherProfile)));

        //Here, we have multiple gaming profile but none for the good game
        $this->assertEquals("Vous devez avoir un nom d'utilisateur pour pouvoir vous inscrire, renseignez le dans \"Mon profil\"", $applicationChecker->canApply($user, $team));
    }

    /**
     * The user is connected and it's the first time he applies
     */
    public function testCanApplyFirstTime () {
        $user = new User();
        $game = new Game();
        $team = new Team();
        $tournament = new TournamentTeam();

        $team->setTournament($tournament);
        $tournament->setGame($game);
        $game->setName("TestGame");

        $gamingProfile = new GamingProfile();
        $gamingProfile->setGame($game);
        $gamingProfile->setUsername("OtherTestGameUsername");
        $user->setGamingProfiles(new ArrayCollection(array($gamingProfile)));

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);
        //Here, we just don't have any gaming profile
        $this->assertTrue($applicationChecker->canApply($user, $team));
    }

    /**
     * The user is connected and it's the second time he applies for a team (for the same tournament)
     */
    public function testCanApplySecondTeamApplicationSameGame () {
        $user = new User();
        $game = new Game();
        $team = new Team();
        $tournament = new TournamentTeam();

        $team->setTournament($tournament);
        $tournament->setGame($game);
        $game->setName("TestGame");

        $anotherTeam = new Team();
        $team->setTournament($tournament);
        $anotherTeam->setTournament($tournament);

        $gamingProfile = new GamingProfile();
        $gamingProfile->setGame($game);
        $gamingProfile->setUsername("TestGameUsername");
        $user->setGamingProfiles(new ArrayCollection(array($gamingProfile)));

        $user->addApplication($anotherTeam);

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);
        //Here, we try to apply to a team
        $this->assertContains("Vous avez déjà postulé pour une équipe pour ce tournoi :", $applicationChecker->canApply($user, $team));
    }

    /**
     * The user is connected and it's the second time he applies for a team (for the same tournament) and the user is selected as a user in the first team
     */
    public function testCanApplySecondTeamSameGame () {
        $user = new User();
        $game = new Game();
        $team = new Team();
        $tournament = new TournamentTeam();

        $team->setTournament($tournament);
        $tournament->setGame($game);
        $game->setName("TestGame");

        $anotherTeam = new Team();
        $team->setTournament($tournament);
        $anotherTeam->setTournament($tournament);

        $gamingProfile = new GamingProfile();
        $gamingProfile->setGame($game);
        $gamingProfile->setUsername("TestGameUsername");
        $user->setGamingProfiles(new ArrayCollection(array($gamingProfile)));

        $user->addApplication($anotherTeam);
        $user->addTeam($anotherTeam);

        $router = $this->createMock(Router::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method("isGranted")->willReturn(true);
        $teamChecker = $this->createMock(TeamChecker::class);
        $teamChecker->method("isAlreadyApplicant")->willReturn(false);

        $applicationChecker = new ApplicationChecker($router, $authorizationChecker, $teamChecker);
        //Here, we try to apply to a team
        $this->assertContains("Vous avez déjà postulé pour une équipe pour ce tournoi :", $applicationChecker->canApply($user, $team));
    }

    /**
     * The user is connected and try to apply to a team and applied for another team for another game
     */
    public function testCanApplySecondTeamAnotherGame() {
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

    }
}
