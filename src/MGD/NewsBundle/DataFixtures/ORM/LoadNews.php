<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09-05-17
 * Time: 00:21
 */

namespace MGD\NewsBundle\DataFixtures\ORM;


use AppBundle\DataFixtures\ORM\LoadObject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MGD\NewsBundle\Entity\News;
use MGD\UserBundle\Entity\User;

class LoadNews extends LoadObject implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $listNews = array(
            array(
                "title" => "Titre 1",
                "body"  => $this->getLoremIpsum(5),
                "creationDate"  => new \DateTime(),
                "visible"       => true,
                "publicationDate"   => new \DateTime(),
                "image"         => "http://placehold.it/200x150",
                "author"        => "Fontenelle"
            ),
            array(
                "title" => "Titre 2",
                "body"  => $this->getLoremIpsum(3),
                "creationDate"  => new \DateTime(),
                "visible"       => true,
                "publicationDate"   => new \DateTime(),
                "image"         => "http://placehold.it/500x350",
                "author"        => "Fontenelle"
            ),
            array(
                "title" => "Titre 3",
                "body"  => $this->getLoremIpsum(10),
                "creationDate"  => new \DateTime(),
                "visible"       => true,
                "publicationDate"   => new \DateTime(),
                "image"         => null,
                "author"        => "Doe"
            ),
            array(
                "title" => "Titre 4",
                "body"  => $this->getLoremIpsum(10),
                "creationDate"  => new \DateTime(),
                "visible"       => false,
                "publicationDate"   => new \DateTime(),
                "image"         => null,
                "author"        => "Doe"
            ),
        );

        foreach ($listNews as $newsItem) {
            /** @var User $user */
            $user = $this->getReference($newsItem["author"]);

            $news = new News();
            $news->setTitle($newsItem["title"])
                ->setBody($newsItem["body"])
                ->setCreationDate($newsItem["creationDate"])
                ->setCover($newsItem["image"])
                ->setVisible($newsItem["visible"])
                ->setPublicationDate($newsItem["publicationDate"])
                ->setAuthor($user);

            $manager->persist($news);
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
        return 3;
    }
}