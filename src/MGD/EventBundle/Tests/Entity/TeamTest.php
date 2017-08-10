<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 08/08/2017
 * Time: 14:28
 */

namespace MGD\EventBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use MGD\EventBundle\Entity\Team;
use MGD\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamTest extends WebTestCase
{
    /** @var  User */
    private $leader;
    /** @var  Team */
    private $team;
    /** @var  ArrayCollection */
    private $players;

    public function setUp()
    {
        $this->leader = new User();
        $this->team = new Team();

        $player1 = new User();
        $player2 = new User();

        $this->players = new ArrayCollection(array($player1, $player2));
    }

    public function testGetPlayingUserIsCountCorrect()
    {
        $this->team->setLeader($this->leader);

        foreach ($this->players as $player) {
            $this->team->addPlayer($player);
        }

        $this->assertEquals(3, $this->team->getPlayingUsers()->count());
    }

    public function testGetPlayingUserIsLeaderInCount()
    {
        $this->team->setLeader($this->leader);

        $this->assertEquals(1, $this->team->getPlayingUsers()->count());
        $this->assertContains($this->leader, $this->team->getPlayingUsers());
    }

    public function testAddPlayer() {
        $newPlayer = new User();

        $this->team->addPlayer($newPlayer);

        $this->assertCount(1, $this->team->getPlayers());

        foreach ($this->players as $player) {
            $this->team->addPlayer($player);
        }
        $this->assertCount(3, $this->team->getPlayers());
    }

    public function testRemovePlayer() {
        foreach ($this->players as $player) {
            $this->team->addPlayer($player);
        }
        $this->assertCount(2, $this->team->getPlayers());

        $this->team->removePlayer($this->players->get(1));
        $this->assertCount(1, $this->team->getPlayers());
    }
}
