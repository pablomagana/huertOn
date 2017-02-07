<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('HomeBundle:Default:index.html.twig');
    }

    public function findAction($param, $user_latitude, $user_longitude)
    {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');

      $query = $repository->createQueryBuilder('o')
          ->addSelect(
                '( 3959 * acos(cos(radians(' . $user_latitude . '))' .
                    '* cos( radians( o.latitude ) )' .
                    '* cos( radians( o.longitude )' .
                    '- radians(' . $user_longitude . ') )' .
                    '+ sin( radians(' . $user_latitude . ') )' .
                    '* sin( radians( o.latitude ) ) ) ) as distance')
          ->where("o.town LIKE :param OR o.zipCode LIKE :param OR o.name LIKE :name")
          ->setParameter('param', $param)
          ->setParameter('name','%'.$param.'%')
          ->orderBy('distance', 'ASC')
          ->getQuery();

      $orchards = $query->getResult();

      if (!$orchards) {
        echo "vacio";
      }

      return $this->render('HomeBundle:Default:index.html.twig', array('orchards' => $orchards));
    }
}
