<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
  public function indexAction(){
    $id_user=1;
    $id_orchard=0;
    $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id_user);
    if(isset($POST["idOrchard"])){
      $id = $POST["idOrchard"];
      $id_orchard = checkIdOrchard($id);
    }
    return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName() , 'idOrchard'->$id_orchard));
  }
  public function createAction()
  {
    if(isset($POST["idOrchard"])){
      $id = $GET["idOrchard"];
      $id_orchard = checkIdOrchard($id);
    }
    if(checkStepOrchard($id)>0){
      switch ($id_step) {
        case :
          return $this->render('OrchardBundle:Default:step11.html.twig');
          break;
        case :
          return $this->render('OrchardBundle:Default:step12.html.twig');
          break;
        default:
          $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id_user);
          return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName() , 'idOrchard'->$id_orchard));
          break;
      }

    }else{
      $id_user=1;
      $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id_user);
      return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName() , 'idOrchard'->$id_orchard));
    }
    $step=0;

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
      $orchard->setGeometry($geometry);

      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();

      $id = $orchard->getId();
      return new JsonResponse(array('id' => $id));
  }
}

public function checkIdOrchard($id_orchard){
  $orchard=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
  return $orchard->getid();
}
public function checkStepOrchard($id_orchard){
  $orchard=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
  return $orchard->getStep();
}
