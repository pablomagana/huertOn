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
      $coordenadas=json_decode($orchards[0]->getGeometry())->geometry->coordinates;
      print_r ($coordenadas);
      print_r("<br/>");
      print_r($this->getDistance($coordenadas[1],$coordenadas[0],39.468536, -0.377441)." Km");
      return $this->render('HomeBundle:Default:index.html.twig',array('orchards' => $orchards ));
    }

    //obtener distancia entre dos puntos(lat,long)
    public function getDistance($latorchard, $longonrchard, $latUser, $longUser)
    {
        $earth_radius = 6371;
        $dLat = deg2rad($latUser - $latorchard);
        $dLon = deg2rad($longUser - $longonrchard);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latorchard)) * cos(deg2rad($latUser)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
        #return $d * 1000;
        return round($d,2);
    }

    public function orderOrchardByDistance($orchards,$cUser){

      for ($i=0; $i < count($orchads); $i++) {
        $orchard=$orchards[i];
        if (getDistance($coord[1],$coord[0],$cUser[0],$cUser[0],$cUser[1])) {
          
        }
      }

      return $orchards;
    }
}
