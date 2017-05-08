<?php

namespace MGD\NewsBundle\Controller;

use MGD\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * News controller.
 *
 */
class NewsController extends Controller
{
    /**
     * Lists all news entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('MGDNewsBundle:News')->findAll();

        return $this->render('@MGDNews/news/index.html.twig', array(
            'listNews' => $news,
        ));
    }

    /**
     * Finds and displays a news entity.
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(News $news)
    {

        return $this->render('@MGDNews/news/show.html.twig', array(
            'news' => $news,
        ));
    }
}
