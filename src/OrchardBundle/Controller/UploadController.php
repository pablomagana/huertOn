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
  public function uploadImageAction(Request $request,$id_orchard)
  {
    $em=$this->getDoctrine()->getManager();
    $orchard=$this->container->get("orchard_service")->getOrchard($id_orchard);
    if (count($request->files)>0) {
      for ($i=0; $i < count($request->files); $i++) {
        $img=$request->files->get("image-".$i);
        $imagen=new Image();
        $imagen->setimage($img);
        $date = new \DateTime('now');
        $date = $date->format('Y-m-d H:i:s');
        $imagen->setUpdateAt($date);
        $imagen->setOrchard($orchard);

        $em->persist($imagen);
        $em->flush();
      }
    }
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
    $data=$request->files->get("fileNormas");
    if($id_orchard!=null){
      $em=$this->getDoctrine()->getManager();
      $orchard=$this->container->get("orchard_service")->getOrchard($id_orchard);
      if ($data!=null) {
        $normas = new RuleFile();
        $normas->setFile($data);
        $date = new \DateTime('now');
        $date = $date->format('Y-m-d H:i:s');
        $normas->setUpdateAt($date);
        $normas->setOrchard($orchard);

        $em->persist($normas);
        $em->flush();
      }
      if($orchard->getStep()<23){
        $orchard->setStep(23);
        $em->persist($orchard);
        $em->flush();
      }
      return new JsonResponse(23);
    }else {
      return new JsonResponse(null);
    }
  }

  public function deleteFileAction(Request $request,$id_orchard)
  {
    $orchard=$this->container->get("orchard_service")->getOrchard($id_orchard);
    if($orchard){
      $em=$this->getDoctrine()->getManager();
      $normas = $orchard->getRuleFile();
      $em->remove($normas);
      $em->flush();
      return new JsonResponse("ok");
    }else {
      return new JsonResponse("ko");
    }
  }

  public function favouriteAction($id_orchard, $id_image, $favourite)
  {
    $em=$this->getDoctrine()->getManager();

    $images = $em->getRepository("OrchardBundle:Image")->findByOrchard($id_orchard);

    foreach ($images as $image) {
      $image->setFavourite(false);
    }

    $image=$em->getRepository("OrchardBundle:Image")->findOneById($id_image);

    if ($favourite == 'true') {
      $image->setFavourite(true);
    }else {
      $image->setFavourite(false);
    }

    $em = $this->getDoctrine()->getManager();
    $em->persist($image);
    $em->flush();

    return new JsonResponse("ok");
  }
}
