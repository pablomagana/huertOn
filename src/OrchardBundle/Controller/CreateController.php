<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends Controller
{

  public function stepsAction($id_orchard)
  {

    $orchard = null;

    if($id_orchard == null) {
      $orchard = new Orchard();
      $orchard->setUser($this->container->get("orchard_service")->getUser());
      $orchard->setStep('11');
      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();
    }else {
      $this->container->get("orchard_service")->checkOwner($id_orchard);
      $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);
    }

    return $this->render('OrchardBundle:Create:steps.html.twig', array('orchard'=> $orchard));

  }

  public function stepAction($step_orchard, $id_orchard)
  {

    $this->container->get("orchard_service")->checkOwner($id_orchard);

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    $orchard_types = null;
    $orchard_participates = null;
    $orchard_services = null;
    $orchard_activities = null;

    $template = null;

    if($step_orchard <= $orchard->getStep()) {
      $template = 'OrchardBundle:Create:step' . $step_orchard . '.html.twig';
    }else {
      $template = 'OrchardBundle:Create:step' . $orchard->getStep() . '.html.twig';
    }

    if($orchard->getStep() == '13' || $step_orchard == '13') {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
      $orchard_types = $repository->findAll();
    }
    if($orchard->getStep() == '21' || $step_orchard == '21') {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardParticipate');
      $orchard_participates = $repository->findAll();
    }
    if($orchard->getStep() == '32' || $step_orchard == '32') {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardService');
      $orchard_services = $repository->findAll();
    }
    if($orchard->getStep() == '33' || $step_orchard == '33') {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardActivity');
      $orchard_activities = $repository->findAll();
    }

    return $this->render($template, array('orchard' => $orchard, 'orchardTypes' => $orchard_types, 'orchardParticipates' => $orchard_participates, 'orchardServices' => $orchard_services, 'OrchardActivities' => $orchard_activities));

  }

  public function insertAction($id_orchard, Request $request)
  {

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    $params = $request->request->all();

    if ($params != null) {
      foreach($params as $key => $value) {
        if (!empty($value)) {
          $setterName = 'set'.$key;
          $orchard->$setterName($value);
        }
      }
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($orchard);
    $em->flush();

    $response = new JsonResponse();
    $response->setData(array(
      'redirect' => $orchard->getStep()
    ));

    return $response;

  }

  public function typeAction($id_orchard, Request $request)
  {

    $orchard_types = $request->request->get('orchardTypes');

    $em = $this->getDoctrine()->getManager();

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);
    $orchard->setStep('14');

    $orchardTypesArray = array();

    foreach ($orchard_types as $orchard_type) {
      $orchardType = $this->container->get("orchard_service")->getOrchardType($orchard_type);
      $orchardType->addOrchard($orchard);
      array_push($orchardTypesArray, $orchardType);
    }

    $orchard->setType($orchardTypesArray);

    $em->persist($orchard);
    $em->flush();

    return new Response();

  }

  public function draftAction()
  {
    return $this->render('OrchardBundle:Create:draft.html.twig');
  }

}
