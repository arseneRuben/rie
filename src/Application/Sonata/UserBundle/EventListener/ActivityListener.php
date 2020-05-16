<?php
namespace Application\Sonata\UserBundle\EventListener;
 
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Application\Sonata\UserBundle\Entity\User;
 
class ActivityListener
{
    protected $context;
    protected $em;
 
    public function __construct(SecurityContext $context, EntityManager $manager)
    {
        $this->context = $context;
        $this->em = $doctrine->getManager();
    }
 
    /**
    * Update the user "lastActivity" on each request
    * @param FilterControllerEvent $event
    */
    public function onCoreController(FilterControllerEvent $event)
    {
        // Here we are checking that the current request is a "MASTER_REQUEST", and ignore any subrequest in the process (for example when doing a render() in a twig template)
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
 
        // We are checking a token authentification is available before using the User
        if ($this->context->getToken()) {
            $user = $this->context->getToken()->getUser();
 
            // We are using a delay during wich the user will be considered as still active, in order to avoid too much UPDATE in the database
            $delay = new \DateTime();
            $delay->setTimestamp(strtotime('2 minutes ago'));
 
            // We are checking the User class in order to be certain we can call "getLastActivity".
            if ($user instanceof User && $user->getLastActivity() < $delay) {
                $user->isActiveNow();
                $this->em->flush($user);
            }
        }
    }
}