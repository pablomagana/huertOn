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

class ShowController extends Controller
{

  public function profileAction($id_orchard)
  {

    $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

    return $this->render('OrchardBundle:Show:profile.html.twig', array('orchard' => $orchard));

  }

}
