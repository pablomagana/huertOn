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
      $orchard->setStep('11');
      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();
      $id_orchard = $orchard->getId();
    }else {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');
      $orchard = $repository->findOneById($id_orchard);
      $user = $this->get('security.token_storage')->getToken()->getUser();
      if($user != $orchard->getUser()) {
        throw new AccessDeniedHttpException('Acceso denegado');
      }
    }

    return $this->render('OrchardBundle:Default:steps.html.twig', array('idOrchard'=> $id_orchard, 'stepOrchard' => $orchard->getStep()));

  }

  public function stepAction($step, $id_orchard)
  {
    if($id_orchard=='null'){$id_orchard=null;}
    $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userName = $user->getUsername();
    $userId = $user->getId();

    $orchard = new Orchard();

    $step_orchard = 11;//def

    if($id_orchard != null){
      $orchard=$this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
      if($orchard!=null && $orchard->getUser()->getId()==$userId){
        $step_orchard = $orchard->getStep();
        switch ($step) {
          case 11:case 12:case 15:case 24:case 25:
          if($step <= $step_orchard) {
            return $this->render('OrchardBundle:Default:step'.$step.'.html.twig', array('orchard' => $orchard));
            break;
          }
          case 13:
          if( $step <= $step_orchard) {
            $repository = $this->getDoctrine()->getRepository('OrchardBundle:Image');
            $images = $repository->findByOrchard($orchard);
            return $this->render('OrchardBundle:Default:step13.html.twig', array('orchard' => $orchard,"images" =>$images));
            break;
          }
          case 14:
          if( $step <= $step_orchard) {
            $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
            $orchard_types = $repository->findAll();
            return $this->render('OrchardBundle:Default:step14.html.twig', array('orchard' => $orchard, 'orchard_types' => $orchard_types));
            break;
          }
          case 21:
          if( $step <= $step_orchard) {
            $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardActivity');
            $orchard_activities = $repository->findAll();
            return $this->render('OrchardBundle:Default:step21.html.twig', array('orchard' => $orchard, 'orchard_activities' => $orchard_activities));
            break;
          }
          case 22:
          if( $step <= $step_orchard) {
            $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardService');
            $orchard_services = $repository->findAll();
            return $this->render('OrchardBundle:Default:step22.html.twig', array('orchard' => $orchard, 'orchard_services' => $orchard_services));
            break;
          }
          case 23:
          if( $step <= $step_orchard) {
            $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardParticipate');
            $orchard_participates = $repository->findAll();
            return $this->render('OrchardBundle:Default:step23.html.twig', array('orchard' => $orchard, 'orchard_participates' => $orchard_participates));
            break;
          }

          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig', array('orchard' => $orchard));
          break;

          default:
          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig', array('orchard' => $orchard));
          break;
        }
      }else {
        return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $userName, 'step' => $step_orchard));
      }
    }else {
      # id_orchard = null
      return $this->render('OrchardBundle:Default:step11.html.twig', array('orchard' => $orchard));
    }

    settype($step_orchard, 'integer');
  }

  //Método utilizado para insertar un huerto en la BBDD
  //Recibe los campos del formulario correspondiente mediante el método POST
  public function insertAction($id_orchard,Request $request)# null si todavia no se ha creado
  {
    if($id_orchard=='null'){$id_orchard=null;}
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $id=$user->getId();

    if($id_orchard == null) {
      //El huerto no está creado así que creamos el objeto
      //$orchard = new Orchard();
      $orchard->setUser($user);
    }else {
      $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
      $id_o=$orchard->getUser()->getId();
    }


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
      'redirect' => $id."/".$orchard->getStep()
    ));

    return $response;

  }

  public function previewAction($id_orchard,Request $request)
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
}
