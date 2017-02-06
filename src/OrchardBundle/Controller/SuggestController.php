<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OrchardBundle\Entity\OrchardType;
use Symfony\Component\HttpFoundation\Response;

class SuggestController extends Controller
{

  public function sendAction($orchard_type)
  {

    $this->sendMail('Nueva sugerencia para tipos de huerto', 'ab95david@gmail.com', $orchard_type, null);

    return new Response();

  }

  public function descriptionAction($orchard_type, $accept)
  {

    if($accept == 'true') {
      return $this->render('OrchardBundle:Suggest:description.html.twig', array('orchardType' => $orchard_type));
    }else {
      $this->sendMail('No se ha aceptado la sugerencia para tipos de huerto', $this->container->get("orchard_service")->getUser(), $orchard_type, $accept);

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

      $this->sendMail('Se ha aceptado la sugerencia para tipos de huerto', $this->container->get("orchard_service")->getUser()->getEmail(), $orchard_type, 'true');

      return $this->redirectToRoute('orchard_create_draft');

  }

  public function sendMail($subject, $to, $orchard_type, $accept)
  {

    $message = \Swift_Message::newInstance()
    ->setContentType("text/html")
    ->setSubject($subject)
    ->setFrom('parcellesflorida@gmail.com')
    ->setTo($to)
    ->setBody(
      $this->renderView(
        'OrchardBundle:Suggest:email.html.twig',
        array('orchard_type' => $orchard_type, 'accept' => $accept)
        )
        )
        ;
        $this->get('mailer')->send($message);

  }

}
