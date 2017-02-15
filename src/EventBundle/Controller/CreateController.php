<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EventBundle\Entity\Event;
use EventBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends Controller
{
    public function createAction(Request $request, $id_orchard)
    {
      $this->container->get("orchard_service")->checkOwner($id_orchard);
      $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

      $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $event->setOrchard($orchard);

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('home_homepage');
        }

        return $this->render('EventBundle:Create:create.html.twig', array('form'=>$form->createView()));
    }

    public function listAction()
    {
      return $this->render('EventBundle:Create:list.html.twig');
    }
}
