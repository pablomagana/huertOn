<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

  public function indexAction(Request $request)
  {
    return $this->render('HomeBundle:Default:index.html.twig');
  }

}
