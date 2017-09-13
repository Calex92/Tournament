<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/04/2017
 * Time: 14:02
 */

namespace MGD\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get("app.datatable.user");
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');

            $responseService->setDatatable($datatable);
            $responseService->getDatatableQueryBuilder();

            return $responseService->getResponse();
        }

        return $this->render('MGDAdminBundle:User:index.html.twig', array(
            'datatableUsers' => $datatable,
        ));
    }
}
