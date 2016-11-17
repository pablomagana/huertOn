<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Form\OrchardType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OrchardBundle:Default:index.html.twig');
    }


  public function newAction(Request $request)
  {
    //build the form
    $orchard = new Orchard();
    $form = $this->createForm(OrchardType::class, $orchard);
   
   //handle the submit (will only happen on POST)
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
      
      //get the data
      $event = $form->getData();

      //Uploads them to the DB
      $em = $this->getDoctrine()->getManager();
      $em->persist($event);
      $em->flush();


      return $this -> redirectToRoute('orchard_homepage');
    }


    return $this->render('OrchardBundle:Default:new_orchard.html.twig', array("form" => $form->createView() ));
  }
}
