<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use EventBundle\Entity\Event;
use EventBundle\Entity\EventUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
  // mostrar evento segun id en parametro
  public function profileAction($id_event)
  {
    $event=$this->getDoctrine()->getRepository('EventBundle:Event')->findOneById($id_event);
    return $this->render('EventBundle:Show:profile.html.twig', array('event' => $event));
  }

  // añade un participante al evento
  public function addUserToEventAction($id_event,$amount)
  {
    $user=$this->container->get("orchard_service")->getUser();
    $event= $this->getDoctrine()->getRepository("EventBundle:Event")->findOneById($id_event);
    $em = $this->getDoctrine()->getManager();
    $eventUser=$this->getDoctrine()->getRepository("EventBundle:EventUser")->findOneBy(
      array('event' => $event->getId(), 'user' => $user->getId())
    );
    if (!$eventUser) {
      $eventUser=new EventUser();
      $eventUser->setUser($user);
      $eventUser->setEvent($event);
    }

    if ($amount>$eventUser->getAmount()) {
      $amountFinal=$event->getPlaces()-($amount-$eventUser->getAmount());
    }else {
      $amountFinal=$event->getPlaces()+($eventUser->getAmount()-$amount);
    }

    $eventUser->setAmount($amount);
    $event->setPlaces($amountFinal);

    if (!$event) {
      return new JsonResponse("ko");
    }

    $em->persist($eventUser);
    $em->persist($event);
    $em->flush();

    return new JsonResponse($amount);
  }

}
