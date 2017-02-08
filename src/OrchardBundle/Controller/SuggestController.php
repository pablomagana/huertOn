<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\OrchardParticipate;
use OrchardBundle\Entity\OrchardService;
use OrchardBundle\Entity\OrchardActivity;
use Symfony\Component\HttpFoundation\Response;

class SuggestController extends Controller
{

  public function sendAction($entity, $param)
  {

    $this->sendMail($entity, 'Nueva sugerencia', 'ab95david@gmail.com', $param, null);

    return new Response();

  }

  public function descriptionAction($orchard_type, $accept)
  {

    if($accept == 'true') {
      return $this->render('OrchardBundle:Suggest:description.html.twig', array('orchardType' => $orchard_type));
    }else {
      $this->sendMail('orchard_type', 'No se ha aceptado la sugerencia para tipos de huerto', $this->container->get("orchard_service")->getUser()->getEmail(), $orchard_type, $accept);

      return new Response();
    }

  }

  public function insertAction($orchard_type, $description) {

      $orchardType = new OrchardType();
      $orchardType->setName($orchard_type);
      $orchardType->setDescription($description);
      $em = $this->getDoctrine()->getManager();
      $em->persist($orchardType);
      $em->flush();

      $this->sendMail('orchard_type', 'Se ha aceptado la sugerencia para tipos de huerto', $this->container->get("orchard_service")->getUser()->getEmail(), $orchard_type, 'true');

      return $this->redirectToRoute('home_homepage');

  }

  public function checkboxAction($entity, $param, $accept) {

    if($accept == 'true') {

      $checkbox_entity = null;

      switch ($entity) {
        case 'OrchardParticipate':
        $checkbox_entity = new OrchardParticipate();
        break;
        case 'OrchardService':
        $checkbox_entity = new OrchardService();
        break;
        case 'OrchardActivity':
        $checkbox_entity = new OrchardActivity();
        break;
      }

      $checkbox_entity->setName($param);
      $em = $this->getDoctrine()->getManager();
      $em->persist($checkbox_entity);
      $em->flush();

    }

    $entity_email = substr_replace(strtolower($entity), '_', 7, 0);

    $this->sendMail($entity_email, 'Resultado sugerencia Huerton', $this->container->get("orchard_service")->getUser()->getEmail(), $param, $accept);

    return $this->redirectToRoute('home_homepage');

  }

  public function sendMail($entity, $subject, $to, $param, $accept)
  {

    $message = \Swift_Message::newInstance()
    ->setContentType("text/html")
    ->setSubject($subject)
    ->setFrom('parcellesflorida@gmail.com')
    ->setTo($to)
    ->setBody(
      $this->renderView(
        'OrchardBundle:Suggest:' . $entity . '_email.html.twig',
        array($entity => $param, 'accept' => $accept)
        )
        )
        ;
        $this->get('mailer')->send($message);

  }

}
