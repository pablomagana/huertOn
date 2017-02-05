<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\OrchardType;
use OrchardBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  //Método utilizado para redirigir a un paso en concreto de la creación de un huerto
  //Recibe el id del huerto que se está creando mediante el método GET (el número del paso al que se redirigirá se gestiona según este id)
  public function indexAction($id_orchard)
  {
    // //Recogemos el usuario para mostrar el mensaje de bienvenida
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userName = $user->getUsername();
    $userId = $user->getId();
    $step_orchard=0;//def
    if($id_orchard != null){
      $orchard=$this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
      if($orchard!=null){
        if($orchard->getUser()->getId()==$userId){
          # huerto detectado que pertenece al usuario logeado
          $step_orchard = $orchard->getStep();
          # Devolvemos la plantilla de pasos marcando los pasos que ya están completados con un icono (falta incluir textos en gris), y pasándole el id del usuario para mostrar el mensaje de bienvenida.
          return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $userName, 'idOrchard'=> $id_orchard, 'step' => $step_orchard));
        }else {
          # el huerto no pertenece al usuario
          return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $userName, 'idOrchard'=> 'null', 'step' => $step_orchard));
        }
      }else {
        return $this->redirectToRoute('orchard_create_id');
      }
    }else {
      //Si no existe id de huerto pasamos el paso 0 (si el paso es 0 se ejecuta la ruta para acceder al paso por defecto, es decir, al 11) y empezamos a crear el huerto
      return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $userName, 'idOrchard'=> 'null', 'step' => $step_orchard));
    }
  }

  //Método utilizado para redirigir a un paso en concreto de la creación un huerto
  //Recibe el número del paso al que se quiere acceder (por defecto al primero) mediante el método GET
  public function createAction($id_orchard, $step)
  {
    if($id_orchard=='null'){$id_orchard=null;}
    $repository = $this->getDoctrine()->getRepository('OrchardBundle:Orchard');
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $userName = $user->getUsername();
    $userId = $user->getId();

    $orchard = new Orchard();

    $step_orchard = 11;//def

    if($id_orchard != null){
        $orchard=$this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
        if($orchard!=null && $orchard->getUser()->getId()==$userId){
          $step_orchard = $orchard->getStep();
          switch ($step) {
            case 11:case 12:case 15:case 24:case 25:
              if($step <= $step_orchard) {
                return $this->render('OrchardBundle:Default:step'.$step.'.html.twig', array('orchard' => $orchard));
                break;
              }
            case 13:
              if( $step <= $step_orchard) {
                $repository = $this->getDoctrine()->getRepository('OrchardBundle:Image');
                $images = $repository->findByOrchard($orchard);
                return $this->render('OrchardBundle:Default:step13.html.twig', array('orchard' => $orchard,"images" =>$images));
                break;
              }
            case 14:
              if( $step <= $step_orchard) {
                $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
                $orchard_types = $repository->findAll();
                return $this->render('OrchardBundle:Default:step14.html.twig', array('orchard' => $orchard, 'orchard_types' => $orchard_types));
                break;
              }
            case 21:
              if( $step <= $step_orchard) {
                $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardActivity');
                $orchard_activities = $repository->findAll();
                return $this->render('OrchardBundle:Default:step21.html.twig', array('orchard' => $orchard, 'orchard_activities' => $orchard_activities));
                break;
              }
            case 22:
              if( $step <= $step_orchard) {
                $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardService');
                $orchard_services = $repository->findAll();
                return $this->render('OrchardBundle:Default:step22.html.twig', array('orchard' => $orchard, 'orchard_services' => $orchard_services));
                break;
              }
            case 23:
              if( $step <= $step_orchard) {
                $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardParticipate');
                $orchard_participates = $repository->findAll();
                return $this->render('OrchardBundle:Default:step23.html.twig', array('orchard' => $orchard, 'orchard_participates' => $orchard_participates));
                break;
              }

            return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig', array('orchard' => $orchard));
            break;

            default:
              return $this->render('OrchardBundle:Default:step' . $step_orchard . '.html.twig', array('orchard' => $orchard));
              break;
          }
        }else {
          return $this->render('OrchardBundle:Default:steps.html.twig', array('userName' => $userName, 'step' => $step_orchard));
        }
    }else {
      # id_orchard = null
      return $this->render('OrchardBundle:Default:step11.html.twig', array('orchard' => $orchard));
    }

      settype($step_orchard, 'integer');
  }

  //Método utilizado para insertar un huerto en la BBDD
  //Recibe los campos del formulario correspondiente mediante el método POST
  public function insertAction($id_orchard,Request $request)# null si todavia no se ha creado
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $orchard = null;

    $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
    if($orchard!=null && $ $user->getId()) {
      //El huerto está creado así que recuperamos el objeto de BBDD
      $orchard = $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->findOneById($id_orchard);
    }else {
      //El huerto no está creado así que creamos el objeto
      $orchard = new Orchard();
      $orchard->setUser($user);
    }

    // Recoje todos los valores del form
    $params = $request->request->all();

    // Recorremos el $key y $value del formulario para separar el id y su valor para añadirlo en la bd
    if ($params != null) {
      foreach($params as $key => $value) {
        if (!empty($value)) {
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

    //devolvemos el id del huerto acabado de crear o de actualizar (en el caso de estar actualizando el registro no haria falta pero lo dejamos para que sea un método más genérico).
    $response = new JsonResponse();
    $response->setData(array(
        'redirect' => $id."/".$orchard->getStep()
    ));

    return $response;

  }

    public function previewAction($id_orchard,Request $request)
    {
      $user = $this->get('security.token_storage')->getToken()->getUser();
      $userName = $user->getUsername();
      $userId = $user->getId();

      #recuperar el huerto
      $orchard= $this->getDoctrine()->getRepository('OrchardBundle:Orchard')->find($id_orchard);

      if($id_orchard!=null){
        # Devuelve TODAS las imagenes
        $images = $orchard->getImages();
        $orchard_types = $orchard->getType();
        # Devuelve TODOS los tipos de huertos
        # $repository = $this->getDoctrine()->getRepository('OrchardBundle:OrchardType');
        # $orchard_types = $repository->findAll();
      }

      return $this->render('OrchardBundle:Default:preview.html.twig', array('userName' => $userName, 'images' =>$images, 'orchard_types' =>$orchard_types));
    }
 }
