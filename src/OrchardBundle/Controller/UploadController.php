<?php

namespace OrchardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OrchardBundle\Entity\Orchard;
use OrchardBundle\Entity\Image;
use OrchardBundle\Entity\RuleFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadController extends Controller
{

  /*//Método utilizado para añadir imagenes a los huertos, recibe una imagen y la mueve a la carpeta de imagenes relacionandola con el huerto
  //Recibe una imagen por request con su descripción por metodo POST
  public function uploadImageActionOld(Request $request,$id_orchard){
    $name=$request->get("name");
    $src=$request->get("src");
    $description=$request->get("description");

    $imagen=new Image();
    $imagen->setSrc($src);
    $imagen->setDescription($description);
    $orchard=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
    $imagen->setOrchard($orchard);

    $em=$this->getDoctrine()->getManager();
    $em->persist($imagen);
    $em->flush();

    return new JsonResponse($imagen->getId());
  }*/

  public function uploadImageAction(Request $request,$id_orchard)
  {

    ini_set('memory_limit', '-1');
    //extraer id_orchard

    //extraer json con imagenes
    //$imagenes=$request->get("imgs");
    $imagenes=json_decode($request->getContent());
    //print_r($imagenes);
    //return new JsonResponse($imagenes[0]->des);

    $em=$this->getDoctrine()->getManager();

    $orchard=$this->getDoctrine()->getRepository("OrchardBundle:Orchard")->findOneById($id_orchard);
    if (count($imagenes)>0) {
      foreach ($imagenes as $img) {
        $imagen=new Image();
        $imagen->setSrc($img->src);
        $imagen->setDescription($img->des);

        $imagen->setOrchard($orchard);

        $em->persist($imagen);
        $em->flush();
      }
    }
    //update step orchard
    if($orchard->getStep()<21){
      $orchard->setStep(21);
      $em->persist($orchard);
      $em->flush();
    }

    return new JsonResponse(21);

  }


  public function deleteImageAction($idImage){
    if($idImage!=null){
      $em=$this->getDoctrine()->getManager();
      $image=$em->getRepository("OrchardBundle:Image")->findOneById($idImage);
      if(!$image){
        return new JsonResponse("image not found width id"+$idImage);
      }

      $em->remove($image);
      $em->flush();
      return new JsonResponse("ok");
    }else {
      return new JsonResponse("ko");
    }
  }

  public function modifyImageAction($idImage,Request $request){
    if($idImage!=null){
      $em=$this->getDoctrine()->getManager();
      $image=$em->getRepository("OrchardBundle:Image")->findOneById($idImage);

      if(!$image){
        return new JsonResponse("image not found width id"+$idImage);
      }
      $des=$request->getContent();
      $image->setDescription(explode("=",$des)[1]);
      $em->flush();
      return new JsonResponse("ok");
    }else {
      return new JsonResponse("ko");
    }
  }

  public function uploadFileAction(Request $request,$id_orchard)
  {
    if($id_orchard!=null){
      $data=$request->files->get("fileNormas");

      $normas = new RuleFile();
      $normas->setFile($data);
      $date = new \DateTime('now');
      $date = $date->format('Y-m-d H:i:s');
      $normas->setUpdateAt($date);
      $normas->setOrchard($this->container->get("orchard_service")->getOrchard($id_orchard));
      $em=$this->getDoctrine()->getManager();
      $em->persist($normas);
      $em->flush();
      return new JsonResponse(23);
    }else {
      throw new NotFoundHttpException('id_orchard no efpecificado');
    }
  }
}
