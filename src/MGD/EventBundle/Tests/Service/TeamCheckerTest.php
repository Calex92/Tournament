<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 14/08/2017
 * Time: 16:32
 */

namespace MGD\EventBundle\Tests\Service;


use Doctrine\Common\Collections\ArrayCollection;
use MGD\EventBundle\Service\TeamChecker;
use PHPUnit\Framework\TestCase;

class TeamCheckerTest extends TestCase
{
    public function testIsDeletableIsAdmin() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(true);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $team = $this->createMock("MGD\EventBundle\Entity\Team");

        $this->assertTrue($teamChecker->isDeletable($team, $user));
    }

    public function testIsDeletableNotTheLeader() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(false);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user->method("getId")->willReturn(1);

        $user2 = $this->createMock("MGD\UserBundle\Entity\User");
        $user2->method("getId")->willReturn(2);

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getLeader")->willReturn($user2);

        $this->assertFalse($teamChecker->isDeletable($team, $user));
    }

    public function testIsDeletableIsTheLeaderAndIsPaid() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(false);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user->method("getId")->willReturn(1);

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getLeader")->willReturn($user);
        $team->method("isPaid")->willReturn(true);

        $this->assertFalse($teamChecker->isDeletable($team, $user));
    }

    public function testIsDeletableIsTheLeaderAndIsNotPaid() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(false);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $user->method("getId")->willReturn(1);

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $team->method("getLeader")->willReturn($user);
        $team->method("isPaid")->willReturn(false);

        $this->assertTrue($teamChecker->isDeletable($team, $user));
    }

    public function testIsAlreadyApplicantIsNotLoggedIn() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(false);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");
        $team = $this->createMock("MGD\EventBundle\Entity\Team");

        $this->assertFalse($teamChecker->isAlreadyApplicant($user, $team));
    }

    public function testIsAlreadyApplicantIsManagerAnotherTeam() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(true);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");
        $tournament2 = $this->createMock("MGD\EventBundle\Entity\Tournament");

        $tournament->method("getId")->willReturn(2);
        $tournament2->method("getId")->willReturn(3);

        $teamUserManaging = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array($teamUserManaging)));
        $user->method("getApplications")->willReturn(new ArrayCollection(array()));
        $user->method("getTeams")->willReturn(new ArrayCollection(array()));

        $team->method("getTournament")->willReturn($tournament);
        $teamUserManaging->method("getTournament")->willReturn($tournament2);

        $this->assertFalse($teamChecker->isAlreadyApplicant($user, $team));
    }

    public function testIsAlreadyApplicantIsManagerTeamThisTournament() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(true);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");

        $tournament->method("getId")->willReturn(2);

        $teamUserManaging = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array($teamUserManaging)));
        $user->method("getApplications")->willReturn(new ArrayCollection(array()));
        $user->method("getTeams")->willReturn(new ArrayCollection(array()));

        $team->method("getTournament")->willReturn($tournament);
        $teamUserManaging->method("getTournament")->willReturn($tournament);

        $this->assertEquals($teamUserManaging, $teamChecker->isAlreadyApplicant($user, $team));
    }

    public function testIsAlreadyApplicantIsApplicantTeamThisTournament() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(true);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");

        $tournament->method("getId")->willReturn(2);

        $teamUserManaging = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array()));
        $user->method("getApplications")->willReturn(new ArrayCollection(array($teamUserManaging)));
        $user->method("getTeams")->willReturn(new ArrayCollection(array()));

        $team->method("getTournament")->willReturn($tournament);
        $teamUserManaging->method("getTournament")->willReturn($tournament);

        $this->assertEquals($teamUserManaging, $teamChecker->isAlreadyApplicant($user, $team));
    }

    public function testIsAlreadyApplicantIsPlayerTeamThisTournament() {
        $authorizationChecker = $this->createMock("Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface");
        $authorizationChecker->method("isGranted")->willReturn(true);

        $teamChecker = new TeamChecker($authorizationChecker);
        $user = $this->createMock("MGD\UserBundle\Entity\User");

        $team = $this->createMock("MGD\EventBundle\Entity\Team");
        $tournament = $this->createMock("MGD\EventBundle\Entity\Tournament");

        $tournament->method("getId")->willReturn(2);

        $teamUserManaging = $this->createMock("MGD\EventBundle\Entity\Team");
        $user->method("getManagedTeam")->willReturn(new ArrayCollection(array()));
        $user->method("getApplications")->willReturn(new ArrayCollection(array()));
        $user->method("getTeams")->willReturn(new ArrayCollection(array($teamUserManaging)));

        $team->method("getTournament")->willReturn($tournament);
        $teamUserManaging->method("getTournament")->willReturn($tournament);

        $this->assertEquals($teamUserManaging, $teamChecker->isAlreadyApplicant($user, $team));
    }
}
