<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
  public function indexAction($id){
    $id_user=1;
    $id_orchard=$id;
    $step=0;
    $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id_user);
    if($id!=null){
      //$step = checkStepOrchard($id_orchard);
      $orchard = $this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
      $step = $orchard->getStep();
      return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName() , 'idOrchard'=>$id_orchard,"step"=>$step));
    }else {
      return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName(),"step"=>$step));
    }
  }

  public function createAction($id, $step)
  {
    $id_orchard = $id;
    $step_orchard = 0;

    if($id > 0 && $id != null){
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');

      $step_orchard = $repository->findOneById($id_orchard)->getStep();

      settype($step_orchard, 'integer');
    }

    switch ($step) {
      case 11:
        if($step <= $step_orchard) {
          return $this->render('OrchardBundle:Default:step11.html.twig');
          break;
        }else{
          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
          break;
        }
      case 12:
        if($step <= $step_orchard) {
          return $this->render('OrchardBundle:Default:step12.html.twig');
          break;
      }else{
        return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
        break;
      }
      case 13:
      if( $step <= $step_orchard) {
          return $this->render('OrchardBundle:Default:step13.html.twig');
          break;
      }else{
        return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
        break;
      }
      default:
        return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
        break;
      }
  }

  public function insertAction(Request $request) {
    // Recoje todos los valores del form
    $params = $request->request->all();
    // Recoje el id (problema al refrescar)
    $id = $request->request->get('id');
    // Crea un huerto si no encuetra id
    if(!empty($id)) {
      $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id);
    }else {
      $orchard = new Orchard();
    }
    // Recorremos el $key y $value del formulario para separar el id y su valor para añadirlo en la bd
    if ($params != null) {
      foreach($params as $key => $value) {
        // Ignoramos el autocomplete y id
        if (!empty($value) && ($key != 'autocomplete' || $key != 'id')) {
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
    return new JsonResponse(array('id' => $id));
  }
}
