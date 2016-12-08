<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
  public function indexAction($id_orchard){
    //Id de usuario a piñón hasta crear login y registro
    $id_user = 1;
    $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneById($id_user);
    $step_orchard = 0;
    if($id_orchard != null){
      //Si existe un id de huerto en la ruta recogemos el paso por el que va
      $step_orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard)->getStep();
      //Devolvemos la plantilla de pasos marcando los pasos que ya estàn completados con un icono (falta incluir textos en gris), y pasándole el id del usuario para mostrar el mensaje de bienvenida.
      return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $user->getName(), 'idOrchard'=> $id_orchard, 'step' => $step_orchard));
    }else {
      //Si no existe id de huerto pasamos el paso 0 y empezamos a crear el huerto
      return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $user->getName(), 'step' => $step_orchard));
    }
  }

  public function createAction(Request $request, $step)
  {
    //Comprovar si existe la cookie del id del huerto
    //Si existe significa que se està editando el huerto y sinó se está creando uno nuevo
    $cookies = $request->cookies;

    $step_orchard = 11;

    if ($cookies->has('ID_ORCHARD')) {
      //Si se está editando (si existe la cookie) obtenemos el paso por el que se ha quedado y le cambiamos el tipo
      $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');

      $step_orchard = $repository->findOneById($cookies->get('ID_ORCHARD'))->getStep();

      settype($step_orchard, 'integer');
    }

    //Step pasado por parámetro que se ha definido en el href del botón en steps.html.twig o en la ruta
    switch ($step) {
      case 11:
        if($step < $step_orchard) {
          return $this->render('OrchardBundle:Default:step11.html.twig');
          break;
        }else{
          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
          break;
        }
      case 12:
        if($step <= $step_orchard) {
          return $this->render('OrchardBundle:Default:step12.html.twig');
          break;
        }else{
          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
          break;
        }
      case 13:
        if( $step <= $step_orchard) {
          return $this->render('OrchardBundle:Default:step13.html.twig');
          break;
        }else{
          return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
          break;
        }
      default:
        return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig');
        break;
    }
  }

  public function insertAction(Request $request) {

    $cookies = $request->cookies;

    $orchard = null;

    if($cookies->has('ID_ORCHARD')) {
      //El huerto está creado así que recuperamos el objeto de BBDD
      $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($cookies->get('ID_ORCHARD'));
    }else {
      //El huerto no está creado así que creamos el objeto
      $orchard = new Orchard();
    }

    // Recoje todos los valores del form
    $params = $request->request->all();
    
    // Recorremos el $key y $value del formulario para separar el id y su valor para añadirlo en la bd
    if ($params != null) {
      foreach($params as $key => $value) {
        // Ignoramos el autocomplete
        if (!empty($value) && ($key != 'autocomplete') {
          $setterName = 'set'.$key;
          $orchard->$setterName($value);
        }
      }
    }
    // Meter datos en la bd
    $em = $this->getDoctrine()->getManager();
    $em->persist($orchard);
    $em->flush();

    $id = $orchard->getId();

    //Seteamos la cookie con el id del huerto acabado de crear o de actualizar (en el caso de estar actualizando el registro no haria falta pero lo dejamos para que sea un método más genérico).
    $response = new Response();
    $response->headers->setCookie(new Cookie("ID_ORCHARD", $id));
    $response->sendHeaders();

    return new JsonResponse(array('redirect' => 'step/'.$orchard->getStep()));
  }
}
