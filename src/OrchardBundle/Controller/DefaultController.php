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
    $id=1;
    $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id);
    return $this->render('OrchardBundle:Default:steps.html.twig',array('userName' => $user->getName() ));
  }
  public function createAction($_values)
  {
    switch ($_values) {
      case '1':
        return $this->render('OrchardBundle:Default:step1.html.twig');
        break;
      case '2':
        return $this->render('OrchardBundle:Default:step2.html.twig');
        break;
      case '3':
        return $this->render('OrchardBundle:Default:step3.html.twig');
        break;

      default:
        return $this->render('OrchardBundle:Default:steps.html.twig');
        break;
    }

  }

  public function insertAction(Request $request) {
    if ($request->isXMLHttpRequest()) {

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

      $em = $this->getDoctrine()->getManager();
      $em->persist($orchard);
      $em->flush();

      $id = $orchard->getId();
      return new JsonResponse(array('id' => $id));
    } else {
          // Do something else
    }
  }
}
