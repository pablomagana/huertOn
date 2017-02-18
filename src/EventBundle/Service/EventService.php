<?php

namespace EventBundle\Service;

use EventBundle\Entity\Event;
use OrchardBundle\Entity\Orchard;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventService
{

  private $em;
  private $tokenStorage;

  public function __construct(EntityManager $em, TokenStorage $tokenStorage)
  {
    $this->em = $em;
    $this->tokenStorage = $tokenStorage;
  }

  public function checkOwner($id_event)
  {

    $repository = $this->em->getRepository('EventBundle:Event');
    $event = $repository->findOneById($id_event);

    if (!$event) {
      throw new NotFoundHttpException('El evento no existe');
    }

    if($this->getUser() != $event->getOrchard()->getUser()) {
      throw new AccessDeniedHttpException('Acceso denegado');
    }

  }

  public function getEvent($id_event)
  {
    $repository = $this->em->getRepository('EventBundle:Event');
    return $repository->findOneById($id_event);
  }

  public function getEventUser($array)
  {
    $repository = $this->em->getRepository("EventBundle:EventUser");
    return $repository->findOneBy($array);
  }

  public function getEventUserByEvent($id_event)
  {
    $repository = $this->em->getRepository("EventBundle:EventUser");
    $event = $this->getEvent($id_event);
    return $repository->findOneByEvent($event);
  }

  public function getOrchardEvents($id_orchard)
  {
    $repository = $this->em->getRepository('OrchardBundle:Orchard');
    return $repository->findOneById($id_orchard)->getEvents();
  }

  public function getUser()
  {
    return $this->tokenStorage->getToken()->getUser();
  }

  public function getUserById($id_user)
  {
    $repository = $this->em->getRepository('UserBundle:User');
    return $repository->findOneById($id_user);
  }

}
