<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()
    ->getRepository('EventBundle:Event');

    $query = null;

    $query = $repository->createQueryBuilder('e')
    ->innerJoin('OrchardBundle:Orchard o', 'WITH e.orchard = o.id')
    ->where('e.startDate > :today')
    ->setParameter('today', new \DateTime())
    ->addOrderBy('e.startDate')
    ->setMaxResults(3)
    ->getQuery();
    $events = $query->getResult();

    return $this->render('HomeBundle:Home:index.html.twig', array('events' => $events));
  }

  public function whyAction()
  {
    return $this->render('HomeBundle:Home:why.html.twig');
  }

  public function howAction()
  {
    return $this->render('HomeBundle:Home:how.html.twig');
  }

}
