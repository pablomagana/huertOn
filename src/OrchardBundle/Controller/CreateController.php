<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\OrchardInscriptionStep;
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

    return $this->render($template, array('orchard' => $orchard, 'orchardTypes' => $orchard_types, 'orchardParticipates' => $orchard_participates, 'orchardServices' => $orchard_services, 'orchardActivities' => $orchard_activities));

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

  public function checkboxAction(Request $request, $id_orchard, $entity)
  {

    $getterName = 'get' . $entity;
    $setterName = 'set' . $entity;

    $params = $request->request->get($entity);

    $em = $this->getDoctrine()->getManager();

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    $orchardEntityArray = array();

    if (!empty($params)) {

      foreach ($params as $param) {
        $orchardEntity = $this->container->get("orchard_service")->$getterName($param);
        $orchardEntity->addOrchard($orchard);
        array_push($orchardEntityArray, $orchardEntity);
      }

    }

    $orchard->$setterName($orchardEntityArray);

    $redirect = null;

    switch ($entity) {
      case 'OrchardType':
        $orchard->setStep('14');
        $redirect = '14';
        break;
      case 'OrchardParticipate':
        $orchard->setStep('22');
        $redirect = '22';
        break;
      case 'OrchardActivity':
        $orchard->setStep('34');
        $redirect = '34';
        break;
      case 'OrchardService':
        $orchard->setStep('33');
        $redirect = '33';
        break;
    }

    $em->persist($orchard);
    $em->flush();

    $response = new JsonResponse();
    $response->setData(array(
      'redirect' => $redirect
    ));

    return $response;

  }

  public function customAction(Request $request, $id_orchard)
  {
    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    $em = $this->getDoctrine()->getManager();

    $params = $request->request->get('OrchardInscriptionStep');

    $orchardInscriptionStepsArray = array();

    if (!empty($params)) {

      foreach ($params as $param) {
        $orchardInscriptionStep = new OrchardInscriptionStep();
        $orchardInscriptionStep->setText($param);
        $orchardInscriptionStep->setOrchard($orchard);
        array_push($orchardInscriptionStepsArray, $orchardInscriptionStep);

        $em->persist($orchardInscriptionStep);
      }

    }

    $orchard->setOrchardInscriptionStep($orchardInscriptionStepsArray);

    $orchard->setStep('32');

    $em->persist($orchard);
    $em->flush();

    $response = new JsonResponse();
    $response->setData(array(
      'redirect' => '31'
    ));

    return $response;
  }

  public function draftAction()
  {
    return $this->render('OrchardBundle:Create:draft.html.twig');
  }

  public function publishAction($id_orchard, $publish)
  {
    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);
    if($publish == 'true') {
      $orchard->setPublished(true);
    }else {
      $orchard->setPublished(false);
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($orchard);
    $em->flush();

    return $this->redirect($this->generateUrl('orchard_create_draft'));

  }
}
