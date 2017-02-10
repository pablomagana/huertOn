<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

  public function indexAction(Request $request)
  {
    return $this->render('HomeBundle:Default:index.html.twig');
  }

  public function findAction(Request $request)
  {
    $input_home_search = $request->request->get('input-home_search');
    $user_latitude = $request->request->get('user_latitude');
    $user_longitude = $request->request->get('user_longitude');

    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()
    ->getRepository('OrchardBundle:Orchard');

    $query = null;
    $type = null;

    if($user_latitude != null || $user_longitude != null) {
      $type = 'distance';
      $query = $repository->createQueryBuilder('o')
          ->addSelect('( 3959 * acos(cos(radians(' . $user_latitude . '))' .
          '* cos( radians( o.latitude ) )' .
          '* cos( radians( o.longitude )' .
          '- radians(' . $user_longitude . ') )' .
          '+ sin( radians(' . $user_latitude . ') )' .
          '* sin( radians( o.latitude ) ) ) ) as distance')
          ->where('o.name LIKE :param OR o.address LIKE :param')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('distance')
          ->getQuery();
    }else {
      $type = 'updatedAt';
      $query = $repository->createQueryBuilder('o')
          ->where('o.name LIKE :param OR o.address LIKE :param')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('o.updatedAt')
          ->getQuery();
    }

    $orchards = $query->getResult();

    return $this->render('HomeBundle:Default:find.html.twig', array('orchards' => $orchards, 'type' => $type));
  }

  public function showAction($id_orchard)
  {

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    return $this->render('HomeBundle:Default:orchard_profile.html.twig', array('orchard' => $orchard));
  }
  public function searchAction()
  {
    return $this->render('HomeBundle:Default:search.html.twig');
  }
}
