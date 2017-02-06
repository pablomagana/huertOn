<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OrchardBundle\Util\Util;

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

    return $this->render('OrchardBundle:Default:steps.html.twig', array('orchard'=> $orchard));

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
      $template = 'OrchardBundle:Default:step' . $step_orchard . '.html.twig';
    }else {
      $template = 'OrchardBundle:Default:step' . $orchard->getStep() . '.html.twig';
    }

    switch ($orchard->getStep()) {
      case '13':
        $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
        $orchard_types = $repository->findAll();
        break;
      case '21':
        $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardParticipate');
        $orchard_participates = $repository->findAll();
        break;
      case '32':
        $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardService');
        $orchard_services = $repository->findAll();
        break;
      case '33':
        $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardActivity');
        $orchard_activities = $repository->findAll();
        break;
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
  public function draftAction()
  {
    return $this->render('OrchardBundle:Default:draft.html.twig');
  }
}
