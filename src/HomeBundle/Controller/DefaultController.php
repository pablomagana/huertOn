<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('HomeBundle:Default:index.html.twig');
    }

    /**
    * @Route("/find/{param}")
    */
    public function FindAction($param)
    {
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');

      // createQueryBuilder() automatically selects FROM AppBundle:ORCHARD and aliases it to "o"
      $query = $repository->createQueryBuilder('o')
          ->where("o.town LIKE :param OR o.zipCode LIKE :param OR o.name LIKE :name")
          ->setParameter('param', $param)
          ->setParameter('name','%'.$param.'%')
          //->orderBy('o.name', 'ASC')
          ->getQuery();

      $orchards = $query->getResult();
      if (!$orchards) {
        echo "vacio";
      }
      return $this->render('HomeBundle:Default:index.html.twig',array('orchards' => $orchards ));
    }

    //obtener distancia entre dos puntos(lat,long)
    public function getDistance($latorchard, $longonrchard, $latUser, $longUser)
    {
        $earth_radius = 6371;
        $dLat = deg2rad($latUser - $latContenedor);
        $dLon = deg2rad($longUser - $longCont1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latContenedor)) * cos(deg2rad($latUser)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
        return $d * 1000;
    }

    public function filterOrchard($coordenates){
        ini_set('max_execution_time', 3000);
        if(in_array($coordenates,$this->coordenatesContenedores)) {
            return false;
        }
        array_push($this->coordenatesContenedores,$coordenates);
        return true;
    }
}
