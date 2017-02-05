<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{

  public function stepsAction($id_orchard)
  {

    $orchard = null;
    $step_orchard = null;

    if($id_orchard == null) {
      $orchard = new Orchard();
      $orchard->setUser($this->get('security.token_storage')->getToken()->getUser());
      $orchard->setStep('11');
      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();
      $id_orchard = $orchard->getId();
    }else {
      $this->checkOwner($id_orchard);
      $orchard = $this->getOrchard($id_orchard);
    }

    return $this->render('OrchardBundle:Default:steps.html.twig', array('idOrchard'=> $id_orchard, 'stepOrchard' => $orchard->getStep()));

  }

  public function stepAction($step_orchard, $id_orchard)
  {

    $this->checkOwner($id_orchard);

    $orchard = $this->getOrchard($id_orchard);

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

    $orchard = $this->getOrchard($id_orchard);

    // Recoje todos los valores del form
    $params = $request->request->all();

    // Recorremos el $key y $value del formulario para separar el id y su valor para añadirlo en la bd
    if ($params != null) {
      foreach($params as $key => $value) {
        if (!empty($value)) {
          $setterName = 'set'.$key;
          $orchard->$setterName($value);
        }
      }
    }
    // Meter datos en la bd
    $em = $this->getDoctrine()->getManager();
    $em->persist($orchard);
    $em->flush();

    $id = $orchard->getId();

    //devolvemos el id del huerto acabado de crear o de actualizar (en el caso de estar actualizando el registro no haria falta pero lo dejamos para que sea un método más genérico).
    $response = new JsonResponse();
    $response->setData(array(
      'redirect' => $orchard->getStep()
    ));

    return $response;

  }

  public function previewAction($id_orchard, Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userName = $user->getUsername();
    $userId = $user->getId();

    #recuperar el huerto
    $orchard= $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->find($id_orchard);

    if($id_orchard!=null){
      # Devuelve TODAS las imagenes
      $images = $orchard->getImages();
      $orchard_types = $orchard->getType();
      # Devuelve TODOS los tipos de huertos
      # $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
      # $orchard_types = $repository->findAll();
    }

    return $this->render('OrchardBundle:Default:preview.html.twig', array('userName' => $userName, 'images' =>$images, 'orchard_types' =>$orchard_types));
  }

  public function checkOwner($id_orchard)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');
    $orchard = $repository->findOneById($id_orchard);

    if (!$orchard) {
        throw $this->createNotFoundException('El huerto no existe');
    }

    if($user != $orchard->getUser()) {
      throw new AccessDeniedHttpException('Acceso denegado');
    }
  }

  public function getOrchard($id_orchard)
  {
    $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');
    return $repository->findOneById($id_orchard);
  }

  public function getStep($id_orchard)
  {
    $orchard = $this->getOrchard($id_orchard);

    if($orchard->getName() != null && $orchard->get)

    switch (variable) {
      case 'value':
        # code...
        break;

      default:
        # code...
        break;
    }
  }
}
