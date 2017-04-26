<?php

namespace MGD\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $news = array(
            array(
                "title" => "Titre 1",
                "body"  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla grav",
                "creationDate"  => new \DateTime(),
                "creator"       => array("name"=>"Michel", "firstname"=>"Michel"),
                "image"         => "http://placehold.it/200x150"
            ),
            array(
                "title" => "Titre 2",
                "body"  => "<b>Lorem ipsum dolor sit amet</b>, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla grav",
                "creationDate"  => new \DateTime(),
                "creator"       => array("name"=>"Nom", "firstname"=>"Prénom"),
                "image"         => "http://placehold.it/500x1500"
            ),
            array(
                "title" => "Titre 3",
                "body"  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla gravLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tempor dui eu interdum scelerisque. Nunc congue nulla et arcu dignissim molestie. Donec iaculis eu erat sit amet scelerisque. Donec tincidunt, quam ac molestie elementum, dui dui scelerisque ante, a imperdiet magna metus at odio. Nulla grav",
                "creationDate"  => new \DateTime(),
                "creator"       => array("name"=>"Jean", "firstname"=>"Paul"),
                "image"         => null
            ),
        );
        return $this->render('MGDNewsBundle:Default:index.html.twig',
            array("listNews"  => $news));
    }
}
