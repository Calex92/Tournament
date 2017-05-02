<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 27/04/2017
 * Time: 14:02
 */

namespace MGD\AdminBundle\Controller;


use MGD\UserBundle\Datatables\UserDatatable;
use Sg\DatatablesBundle\Datatable\DatatableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();
        /** @var DatatableInterface $datatable */
        $datatable = $this->get('sg_datatables.factory')->create(UserDatatable::class);
        $datatable->buildDatatable();
        if ($isAjax) {
            return new Response("On est en ajax!");
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);
            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();
            //dump($datatableQueryBuilder->getQb()->getDQL()); die();
            return $responseService->getResponse();
        }

        return $this->render('MGDAdminBundle:User:index.html.twig', array(
            'datatable' => $datatable,
        ));
    }
}
