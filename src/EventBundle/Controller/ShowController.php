<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use EventBundle\Entity\Event;
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
  public function addUserToEventAction($id_event)
  {
    $user=$this->container->get("orchard_service")->getUser();
    $event= $this->getDoctrine()->getRepository("EventBundle:Event")->findOneById($id_event);
    $em = $this->getDoctrine()->getManager();
    if (!$event) {
      return new JsonResponse("ko");
    }
    $event->addUser($user);
    $em->persist($event);
    $em->flush();
  }

}
