<?php

namespace App\EventListener;

use Doctrine\ORM\Events;
use App\Model\BaseEntity;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BaseEntitySubscriber implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * {@inheritdoc}
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var BaseEntity */
        $entidade = $args->getEntity();

        if ($entidade instanceof BaseEntity) {
            $entidade->setCriadoEm(new \DateTime());
            $entidade->setCriadoPor($this->tokenStorage->getToken()->getUser());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        /** @var BaseEntity */
        $entidade = $args->getEntity();

        if ($entidade instanceof BaseEntity) {
            $entidade->setUpdatedAt(new \DateTime());
            $usuario = $this->tokenStorage->getToken()->getUser();
            if ($usuario instanceof User) {
                $entidade->setAtualizadoPor($usuario);
            }
        }
    }
}
