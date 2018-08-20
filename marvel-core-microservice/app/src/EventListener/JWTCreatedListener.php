<?php
/**
 * Created by PhpStorm.
 * User: KxF
 * Date: 31/01/2018
 * Time: 09:21
 */

namespace App\EventListener;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}