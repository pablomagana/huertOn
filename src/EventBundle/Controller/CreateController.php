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

      $event = $this->container->get("event_service")->getEvent($id_event);

      $repository = $em->getRepository('EventBundle:EventUser');
      $eventUsers = $repository->findByEvent($id_event);

      return $this->render('EventBundle:Create:inscribed.html.twig', array('event' => $event, 'eventUsers' => $eventUsers));

    }

    public function deleteInscribedAction($id_event, $id_user)
    {
      $eventUser = $this->container->get("event_service")->getEventUser(array('event' => $id_event, 'user' => $id_user));
      $event = $this->container->get("event_service")->getEvent($id_event);

      $user = $this->container->get("event_service")->getUserById($id_user);

      $event->setPlaces($eventUser->getAmount() + $event->getPlaces());

      $em = $this->getDoctrine()->getManager();
      $em->remove($eventUser);
      $em->flush();

      $em->persist($event);
      $em->flush();

      $message = \Swift_Message::newInstance()
      ->setContentType("text/html")
      ->setSubject('Confirmación registro ' . $event->getTitle())
      ->setFrom('huertOnflorida@gmail.com')
      ->setTo($user->getEmail())
      ->setBody(
        $this->renderView(
          'OrchardBundle:Suggest:confirmation_email.html.twig',
          array('event' => $event, 'action' => false, 'user' => $user, 'amount' => $amount, 'orchard' => $event->getOrchard())
          )
          )
          ;
          $this->get('mailer')->send($message);

      return new JsonResponse("ok");
      
    }
    public function addInscribedAction($id_event, $mail_user, $amount)
    {
      $user=$this->getDoctrine()->getRepository("UserBundle:User")->findOneByEmail($mail_user);

      $event = $this->container->get("event_service")->getEvent($id_event);
      $em = $this->getDoctrine()->getManager();
      $eventUser = $this->container->get("event_service")->getEventUser(array('event' => $event->getId(), 'user' => $user->getId()));

      $response=$this->container->get("event_service")->addUserToEvent($event, $user, $eventUser, $amount);

      $em->persist($response[0]);
      $em->persist($response[1]);
      $em->flush();

      $message = \Swift_Message::newInstance()
      ->setContentType("text/html")
      ->setSubject('Confirmación registro ' . $event->getTitle())
      ->setFrom('huertOnflorida@gmail.com')
      ->setTo($user->getEmail())
      ->setBody(
        $this->renderView(
          'OrchardBundle:Suggest:confirmation_email.html.twig',
          array('event' => $event, 'action' => true, 'user' => $user, 'amount' => $amount, 'orchard' => $event->getOrchard())
          )
          )
          ;
          $this->get('mailer')->send($message);

      return new JsonResponse($response[2]);
    }

}
