<?php

namespace MGD\EventBundle\Controller;

use MGD\EventBundle\Entity\Team;
use MGD\EventBundle\Entity\TournamentTeam;
use MGD\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 */
class TeamController extends Controller
{
    /**
     * Creates a new team entity.
     * @param Request $request
     * @param TournamentTeam $tournamentTeam
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request, TournamentTeam $tournamentTeam)
    {
        if ($this->getUser()->getGamingUsername($tournamentTeam->getGame()) === null) {
            $this->get('session')->getFlashBag()
                ->add("warning", "Vous devez avoir un username pour le jeu ".$tournamentTeam->getGame()->getName()." pour pouvoir créer une équipe pour ce tournoi!");
            return $this->redirectToRoute("fos_user_profile_show");
        }
        $team = new Team();
        $team->setTournament($tournamentTeam);
        $team->setLeader($this->getUser());

        $form = $this->createForm('MGD\EventBundle\Form\TeamType', $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $this->get('session')->getFlashBag()->add("warning", "Pour que votre équipe soit validée, n'oubliez pas de payer l'inscription!");

            return $this->redirectToRoute('mgd_team_show', array('id' => $team->getId()));
        }

        return $this->render('@MGDEvent/Team/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $applicationForm = $this->createApplicationForm($team);

        return $this->render('@MGDEvent/Team/show.html.twig', array(
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
            'application_form' => $applicationForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm('MGD\EventBundle\Form\TeamType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mgd_team_edit', array('id' => $team->getId()));
        }

        return $this->render('@MGDEvent/Team/edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a team entity.
     *
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($team->getLeader()->getId() === $this->getUser()->getId()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($team);
                $em->flush();
            } else {
                $this->get('session')->getFlashBag()->add("danger", "Seul le chef d'équipe peut la supprimer");
            }
        }

        return $this->redirectToRoute('mdg_tournament_view', array("id" => $team->getTournament()->getId()));
    }

    /**
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function applicationAction(Request $request, Team $team)
    {
        $form = $this->createApplicationForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            //First, we check if the user can apply for this team, the function returns the error message to display if he can't
            if (true === $errMessage = $this->get("mgd_event.application_checker")->canApply($user, $team)) {
                $team->addApplicant($user);
                $this->getDoctrine()->getEntityManager()->flush();
            }
            else {
                $this->get("session")->getFlashBag()->add("danger", $errMessage);
            }
        }
        return $this->redirectToRoute('mgd_team_show', array("id" => $team->getId()));
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Team $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgd_team_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete',
                'attr' => array(
                    'onclick' => 'return confirm("Êtes-vous certains de vouloir supprimer cette équipe?\n\nCette action est irreversible!")',
                    'class' => 'btn btn-danger pull-left col-md-2'
                )))
            ->getForm();
    }

    /**
     * Creates a form to apply for a team entity
     * @param Team $team The team entity
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createApplicationForm(Team $team) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mgd_team_application', array('id' => $team->getId())))
            ->setMethod('POST')
            ->add('submit', SubmitType::class, array(
                'label' => 'Rejoindre cette équipe',
                'attr' => array(
                    'class' => 'btn btn-primary pull-right col-md-2'
                )))
            ->getForm();
    }

}
