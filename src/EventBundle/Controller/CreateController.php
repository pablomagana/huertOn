<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EventBundle\Entity\Event;
use EventBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateController extends Controller
{
    public function createAction(Request $request, $id_event, $id_orchard)
    {

      $event = $this->container->get("event_service")->getEvent($id_event);

      $orchard = null;

      if(!$event) {
        $event = new Event();
        if ($id_orchard) {
          $this->container->get("orchard_service")->checkOwner($id_orchard);
          $orchard = $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);
        }
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

    public function inscribedAction($id_event)
    {
      $em = $this->getDoctrine()->getManager();

      $repository = $em->getRepository('EventBundle:EventUser');
      $eventUsers = $repository->findByEvent($id_event);

      $users = array();
      $amounts = array();

      foreach ($eventUsers as $eventUser) {
        array_push($users, $eventUser->getUser());
        array_push($amounts, $eventUser->getAmount());
      }

      return $this->render('EventBundle:Create:inscribed.html.twig', array('users' => $users, 'amounts' => $amounts));
    }
}
