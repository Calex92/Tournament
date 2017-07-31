<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 03/05/2017
 * Time: 11:16
 */

namespace MGD\EventBundle\Controller;


use MGD\EventBundle\Entity\Tournament;
use MGD\EventBundle\Entity\TournamentSolo;
use MGD\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TournamentController extends Controller
{
    public function viewAction($id) {
        /** @var Tournament $tournament */
        $tournament = $this->get("mgd_event.tournament_manager")->getTournament($id);

        return $this->render("MGDEventBundle:Tournament:" . $tournament->getTemplateName(), array(
            "event" => $tournament
        ));
    }

    /**
     * We can join a solo tournament through this action
     *
     * @param TournamentSolo $tournament
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function applyAction(TournamentSolo $tournament) {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->getTournamentsSolo()->contains($tournament)) {
            $user->addTournamentSolo($tournament);
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            $this->addFlash("success", "Vous êtes dorénavant inscrit au tournoi (".$tournament->getTitle()."). Allez consulter votre profil pour plus d'information");
        }
        else {
            $this->addFlash("danger", "Impossible de vous inscrire au tournoi (".$tournament->getTitle()."), vous en faites déjà partie");
        }

        return $this->redirectToRoute("mgd_event_homepage");
    }

    /**
     * @param TournamentSolo $tournament
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function quitAction(TournamentSolo $tournament) {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->getTournamentsSolo()->contains($tournament)) {
            $user->removeTournamentSolo($tournament);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Vous n'êtes plus inscrit à ce tournoi (" . $tournament->getTitle() . ").");
        }
        else {
            $this->addFlash("danger", "Vous n'avez pas ce tournoi dans votre liste");
        }
        return $this->redirectToRoute("mgd_event_homepage");
    }
}
