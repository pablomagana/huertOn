<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

  public function findOrchardAction(Request $request)
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
          ->where('(o.name LIKE :param OR o.address LIKE :param) AND o.published = 1')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('distance')
          ->getQuery();
    }else {
      $type = 'updatedAt';
      $query = $repository->createQueryBuilder('o')
          ->where('(o.name LIKE :param OR o.address LIKE :param) AND o.published = 1')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('o.updatedAt')
          ->getQuery();
    }

    $orchards = $query->getResult();

    return $this->render('HomeBundle:Search:find_orchard.html.twig', array('orchards' => $orchards, 'type' => $type, 'input_home_search' => $input_home_search));
  }



  public function findEventAction(Request $request)
  {
    $input_home_search = $request->request->get('input-home_search');
    $user_latitude = $request->request->get('user_latitude');
    $user_longitude = $request->request->get('user_longitude');

    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()
    ->getRepository('EventBundle:Event');

    $query = null;
    $type = null;

    if($user_latitude != null || $user_longitude != null) {
      $type = 'distance';
      $query = $repository->createQueryBuilder('e')
          ->innerJoin('OrchardBundle:Orchard o', 'WITH e.orchard = o.id')
          ->addSelect('( 3959 * acos(cos(radians(' . $user_latitude . '))' .
          '* cos( radians( o.latitude ) )' .
          '* cos( radians( o.longitude )' .
          '- radians(' . $user_longitude . ') )' .
          '+ sin( radians(' . $user_latitude . ') )' .
          '* sin( radians( o.latitude ) ) ) ) as distance')
          ->where('e.title LIKE :param OR o.name LIKE :param OR o.address LIKE :param')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('distance')
          ->getQuery();
    }else {
      $type = 'startDate';
      $query = $repository->createQueryBuilder('e')
          ->innerJoin('OrchardBundle:Orchard o', 'WITH e.orchard = o.id')
          ->where('e.title LIKE :param OR o.name LIKE :param OR o.address LIKE :param')
          ->setParameter('param', '%' . $input_home_search . '%')
          ->addOrderBy('e.startDate')
          ->getQuery();
    }

    $events = $query->getResult();

    return $this->render('HomeBundle:Search:find_event.html.twig', array('events' => $events, 'type' => $type, 'input_home_search' => $input_home_search));
  }


}
