<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

  public function indexAction()
  {
    return $this->render('HomeBundle:Default:index.html.twig');
  }

  public function findAction(Request $request)
  {
    $param = $request->request->get('param');
    $user_latitude = $request->request->get('user_latitude');
    $user_longitude = $request->request->get('user_longitude');

    $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');

    $query = null;

    if ($user_latitude != null || $user_longitude != null) {
      $query = $repository->createQueryBuilder('o')
      ->addSelect(
        'o.name, o.zipCode, o.town, o.address, ( 3959 * acos(cos(radians(' . $user_latitude . '))' .
        '* cos( radians( o.latitude ) )' .
        '* cos( radians( o.longitude )' .
        '- radians(' . $user_longitude . ') )' .
        '+ sin( radians(' . $user_latitude . ') )' .
        '* sin( radians( o.latitude ) ) ) ) as distance')
        ->innerJoin('OrchardBundle:Image', 'i', 'WITH', 'i.orchard = o.id')
        ->where("(o.town LIKE :param OR o.zipCode LIKE :param OR o.name LIKE :name) AND o.published = 1")
        ->setParameter('param','%'.$param.'%')
        ->setParameter('name','%'.$param.'%')
        ->orderBy('distance', 'ASC')
        ->getQuery();
      }else {
        $query = $repository->createQueryBuilder('o')
        ->addSelect(
          'o.name, o.zipCode, o.town, o.address')
          ->innerJoin('OrchardBundle:Image', 'i', 'WITH', 'i.orchard = o.id')
          ->where("(o.town LIKE :param OR o.zipCode LIKE :param OR o.name LIKE :name) AND o.published = 1")
          ->setParameter('param','%'.$param.'%')
          ->setParameter('name','%'.$param.'%')
          ->orderBy('o.updatedAt', 'ASC')
          ->getQuery();
        }

        $orchards = $query->getResult();

        return $this->render('HomeBundle:Default:find.html.twig', array('orchards' => $orchards, 'param' => $param));
      }

      public function showAction($id_orchard)
      {

        $orchard = $this->container->get("orchard_service")->getOrchard($id_orchard);

        return $this->render('HomeBundle:Default:orchard_profile.html.twig', array('orchard' => $orchard));
      }
      public function searchAction()
      {
        return $this->render('HomeBundle:Default:search.html.twig');
      }
    }
