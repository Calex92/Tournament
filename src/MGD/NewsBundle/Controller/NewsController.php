<?php

namespace MGD\NewsBundle\Controller;

use MGD\NewsBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * Displays the list of the news to the admin
     * @Security("has_role('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction() {
        $news = $this->getDoctrine()->getRepository("MGDNewsBundle:News")->findAll();

        return $this->render('@MGDNews/news/list.html.twig', array(
            "listNews"  => $news
        ));
    }

    /**
     * Creates a new news entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm('MGD\NewsBundle\Form\NewsType', $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('mgd_news_show', array('id' => $news->getId()));
        }

        return $this->render('@MGDNews/news/new.html.twig', array(
            'news' => $news,
            'form' => $form->createView(),
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

    /**
     * Displays a form to edit an existing news entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, News $news)
    {
        $editForm = $this->createForm('MGD\NewsBundle\Form\NewsType', $news);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mgd_news_edit', array('id' => $news->getId()));
        }

        return $this->render('@MGDNews/news/edit.html.twig', array(
            'news' => $news,
            'form' => $editForm->createView()
        ));
    }
}
