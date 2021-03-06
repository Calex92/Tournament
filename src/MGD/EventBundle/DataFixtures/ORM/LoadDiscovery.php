<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 10:04
 */

namespace MGD\EventBundle\DataFixtures\ORM;


use AppBundle\DataFixtures\ORM\LoadObject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\EventBundle\Entity\Discovery;

class LoadDiscovery extends LoadObject implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $titles = array(
            "Découverte jeu de rôle",
            "Découverte jeu de plateau",
            "Petit déjeuner lecture"
        );

        $descriptions = array(
            $this->getLoremIpsum(2),
            $this->getLoremIpsum(4),
            $this->getLoremIpsum(6)
        );

        $startPublicationDates = array(
            new \DateTime("2017-06-10"),
            new \DateTime("2017-04-10"),
            new \DateTime("2017-04-20")
        );

        $endPublicationDates = array(
            new \DateTime("2017-07-10"),
            new \DateTime("2017-08-10"),
            new \DateTime("2017-05-20")
        );

        $startDatesTimes = array(
            new \DateTime("2017-06-10 08:00:00"),
            new \DateTime("2017-05-05 07:30:00"),
            new \DateTime("2017-04-25 10:00:00")
        );

        $endDatesTimes = array(
            new \DateTime("2017-06-10 18:00:00"),
            new \DateTime("2017-05-05 12:00:00"),
            new \DateTime("2017-04-26 10:00:00")
        );

        $covers = array(
            "http://placehold.it/400x250",
            "http://placehold.it/400x250",
            "http://placehold.it/400x250"
        );

        $responsibleNames = array(
            array("Doe", "Michel"),
            array("Fontenelle"),
            array("Doe", "Fontenelle")
        );

        for($i = 0 ; $i < count($titles) ; $i++) {
            $discovery = new Discovery();
            $discovery->setTitle($titles[$i])
                ->setDescription($descriptions[$i])
                ->setCreationDate(new \DateTime())
                ->setStartDate($startDatesTimes[$i])
                ->setStartPublicationDate($startPublicationDates[$i])
                ->setEndDate($endDatesTimes[$i])
                ->setEndPublicationDate($endPublicationDates[$i])
                ->setCover($covers[$i]);

            $responsibles = array();
            foreach ($responsibleNames[$i] as $responsibleName) {
                $responsibles[] = $this->getReference($responsibleName);
            }
            $discovery->setResponsibles($responsibles);
            $manager->persist($discovery);
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
        return 2;
    }
}
