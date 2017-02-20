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
  public function profileAction($id_event, $search)
  {
    $user = $this->container->get("orchard_service")->getUser();
    $event = $this->container->get("event_service")->getEvent($id_event);
    $eventUser = $this->container->get("event_service")->getEventUser(array('event' => $event->getId(), 'user' => $user->getId()));

    return $this->render('EventBundle:Show:profile.html.twig', array('event' => $event , 'eventUser' => $eventUser , 'search' => $search));
  }

  // añade un participante al evento
  public function addUserToEventAction($id_event, $amount, $id_user)
  {
    if ($id_user != null) {
      $user = $this->container->get("event_service")->getUserById($id_user);
    }else {
      $user = $this->container->get("orchard_service")->getUser();
    }

    $event = $this->container->get("event_service")->getEvent($id_event);
    $em = $this->getDoctrine()->getManager();
    $eventUser = $this->container->get("event_service")->getEventUser(array('event' => $event->getId(), 'user' => $user->getId()));

    $response=$this->container->get("event_service")->addUserToEvent($event, $user, $eventUser, $amount);

    $em->persist($response[0]);
    $em->persist($response[1]);
    $em->flush();
    return new JsonResponse($response[2]);
  }

}
