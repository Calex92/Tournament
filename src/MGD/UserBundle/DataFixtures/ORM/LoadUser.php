<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 10:29
 */

namespace MGD\UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\UserBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $firstnames = array(
            "John",
            "Allison",
            "Michel",
            "Barack",
            "Georges",
            "Harrison",
            "Leader1",
            "Leader2",
            "Leader3",
            "Player11",
            "Player12",
            "Player13",
            "Player14",
            "Player21",
            "Player22",
            "Applicant15",
            "Applicant16",
            "Applicant23",
            "Applicant24",
            "Applicant25",
            "Applicant26",
            "Applicant31",
            "Applicant32",

        );

        $lastnames = array(
            "Doe",
            "Fontenelle",
            "Michel",
            "Obama",
            "Washington",
            "Ford",
            "Leader1",
            "Leader2",
            "Leader3",
            "Player11",
            "Player12",
            "Player13",
            "Player14",
            "Player21",
            "Player22",
            "Applicant15",
            "Applicant16",
            "Applicant23",
            "Applicant24",
            "Applicant25",
            "Applicant26",
            "Applicant31",
            "Applicant32",
        );

        $enabled = array(
            true,
            true,
            true,
            true,
            true,
            false,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
        );

        $rolesArray = array(
            array("ROLE_SUPER_ADMIN"),
            array("ROLE_ADMIN"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
            array("ROLE_USER"),
        );

        for ($i = 0 ; $i<count($firstnames) ; $i++) {
            $user = new User();
            $user->setFirstname(    $firstnames[$i]);
            $user->setLastname(     $lastnames[$i]);
            $user->setEnabled(      $enabled[$i]);
            $user->setEmail(        $firstnames[$i].".".$lastnames[$i]."@test.com");
            $user->setPlainPassword("popo");
            $user->setRoles($rolesArray[$i]);

            $manager->persist($user);
            $this->addReference($lastnames[$i], $user);
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