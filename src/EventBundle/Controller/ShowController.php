<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use EventBundle\Entity\Event;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{

  public function profileAction($id_event)
  {

    $event=$this->getRepository("EventBundle:Entity");

    return $this->render('EventBundle:Show:profile.html.twig', array('event' => $event));

  }

}
