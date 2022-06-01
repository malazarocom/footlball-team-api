<?php

namespace App\EventListener;

use App\Entity\Player;
use App\Entity\Trainer;
use Doctrine\ORM\Events;
use App\Service\Notification\Channels\Mail\Mailer;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

class PlayerNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Mailer $mailer
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('remove', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Player && !$entity instanceof Trainer) {
            return;
        }

        $email = $this->mailer->createNotification($entity, $action);
        $this->mailer->sendEmail($email);
    }
}
