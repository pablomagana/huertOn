<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EventBundle\Entity\Event;
use EventBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateController extends Controller
{
    public function createAction(Request $request, $id_event)
    {

      $event = $this->container->get("event_service")->getEvent($id_event);

      $orchard = null;

      if(!$event) {
        $event = new Event();
      }else {
        $orchard = $event->getOrchard();
      }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $id_orchard = $form->get('id_orchard')->getData();

            $this->container->get("orchard_service")->checkOwner($id_orchard);
            $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

            $event->setOrchard($orchard);

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('home_homepage');
        }

        return $this->render('EventBundle:Create:create.html.twig', array('form'=>$form->createView(), 'orchardRelated' => $orchard));
    }

    public function listAction()
    {
      return $this->render('EventBundle:Create:list.html.twig');
    }

    public function orchardAction($id_orchard)
    {
      $events = $this->container->get("event_service")->getOrchardEvents($id_orchard);

      return $this->render('EventBundle:Create:list_events.html.twig', array('events' => $events));
    }
}
