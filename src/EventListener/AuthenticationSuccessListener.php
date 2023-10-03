<?php


namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;




class AuthenticationSuccessListener
{
    #[AsEventListener(event: AuthenticationSuccessEvent::class)]
    public function __invoke(AuthenticationSuccessEvent $event): void
    {
       //dd("ok");
       $user = $event->getAuthenticationToken()->getUser();
      // dd($user);
       if(!($user->isVerified())) {
        throw new AuthenticationException("Verifiez vos emails");
       }
      
    }
}