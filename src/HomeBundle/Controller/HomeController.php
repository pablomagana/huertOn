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

    $repositoryOrchard = $this->getDoctrine()
    ->getRepository('OrchardBundle:Orchard');
    $repositoryEvent = $this->getDoctrine()
    ->getRepository('EventBundle:Event');

    $queryOrchard = null;
    $queryEvent = null;

    $queryOrchard = $repositoryOrchard->createQueryBuilder('o')
    ->addOrderBy('o.createdAt')
    ->setMaxResults(3)
    ->getQuery();
    $orchards = $queryOrchard->getResult();

    $queryEvent = $repositoryEvent->createQueryBuilder('e')
    ->innerJoin('OrchardBundle:Orchard o', 'WITH e.orchard = o.id')
    ->where('e.startDate >= :today')
    ->setParameter('today', new \DateTime())
    ->addOrderBy('e.startDate')
    ->setMaxResults(3)
    ->getQuery();
    $events = $queryEvent->getResult();

    return $this->render('HomeBundle:Home:index.html.twig', array('orchards' => $orchards, 'events' => $events));
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
