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

class UserController extends Controller
{
    public function indexAction() {
        /** @var DatatableInterface $datatable */
        $datatable = $this->get('sg_datatables.factory')->create(UserDatatable::class);
        $datatable->buildDatatable();

        return $this->render('MGDAdminBundle:User:index.html.twig', array(
            'datatable' => $datatable,
        ));
    }
}
