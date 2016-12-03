<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Response;
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
      $step=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard)->getStep();
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
      $id = $request->request->get('id');
      $name = $request->request->get('name');
      $town = $request->request->get('town');
      $street = $request->request->get('street');
      $number = $request->request->get('number');
      $zipCode = $request->request->get('zipcode');
      $geometry = $request->request->get('geometry');

      $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id);
      if($orchard == null) {
        $orchard = new Orchard();
      }

      $orchard->setName($name);
      $orchard->setTown($town);
      $orchard->setStreet($street);
      $orchard->setNumber($number);
      $orchard->setZipCode($zipCode);
      $geometry->setGeometry($geometry);
      $orchard->setGeometry($geometry);

      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();

      $id = $orchard->getId();
      return new JsonResponse(array('id' => $id));
  }

  public function checkIdOrchard($id_orchard){
    $orchard=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
    return $orchard->getid();
  }
  public function checkStepOrchard($id_orchard){
    $step=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard)->getStep();
    return $step;
  }

}
