<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 15/05/2017
 * Time: 18:02
 */

namespace MGD\EventBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\EventBundle\Entity\Game;

class LoadGame extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = ["League of Legends", "Hearthstone", "CS:GO", "Pokemon", "Clash Royale", "Overwatch"];

        foreach ($names as $name) {
            $game = new Game();
            $game->setName($name);

            $manager->persist($game);
            $this->addReference($name, $game);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}