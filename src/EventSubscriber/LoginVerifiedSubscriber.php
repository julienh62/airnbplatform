<?php   

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;




class LoginVerifiedSubscriber implements EventSubscriberInterface
{
   
    public static function getSubscribedEvents()
    {
        return [
        //   AuthenticationSuccessEvent::class => 'loginVerified'
       //commenté car on utilise EventListener
       // à decommenter si on uitlise pas EventListener 
        ];
    }
    public function loginVerified(AuthenticationSuccessEvent $event): void
    {
       //dd("ok");
       $user = $event->getAuthenticationToken()->getUser();
      // dd($user);
       if(!($user->isVerified())) {
        throw new AuthenticationException("Verifiez vos emails");
       }
      
    }
 }      