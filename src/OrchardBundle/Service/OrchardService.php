<?php

namespace OrchardBundle\Service;

use OrchardBundle\Entity\Orchard;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrchardService
{

  private $em;
  private $tokenStorage;

  public function __construct(EntityManager $em, TokenStorage $tokenStorage)
  {
    $this->em = $em;
    $this->tokenStorage = $tokenStorage;
  }

  public function checkOwner($id_orchard)
  {

    $repository = $this->em->getRepository('OrchardBundle:Orchard');
    $orchard = $repository->findOneById($id_orchard);

    if (!$orchard) {
      throw new NotFoundHttpException('El huerto no existe');
    }

    if($this->getUser() != $orchard->getUser()) {
      throw new AccessDeniedHttpException('Acceso denegado');
    }

  }

  public function getOrchard($id_orchard)
  {
    $repository = $this->em->getRepository('OrchardBundle:Orchard');
    return $repository->findOneById($id_orchard);
  }

  public function getOrchardType($param)
  {
    $repository = $this->em->getRepository('OrchardBundle:OrchardType');
    return $repository->findOneById($param);
  }

  public function getOrchardParticipate($param)
  {
    $repository = $this->em->getRepository('OrchardBundle:OrchardParticipate');
    return $repository->findOneById($param);
  }

  public function getOrchardActivity($param)
  {
    $repository = $this->em->getRepository('OrchardBundle:OrchardActivity');
    return $repository->findOneById($param);
  }

  public function getOrchardService($param)
  {
    $repository = $this->em->getRepository('OrchardBundle:OrchardService');
    return $repository->findOneById($param);
  }

  public function getOrchardInscriptionStep($param)
  {
    $repository = $this->em->getRepository('OrchardBundle:OrchardInscriptionStep');
    return $repository->findOneById($param);
  }

  public function getUser()
  {
    return $this->tokenStorage->getToken()->getUser();
  }

}
