<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Enquiry;
use AppBundle\Entity\Temoignage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\Sonata\UserBundle\Entity\User;

/**
 * Enquiry controller.
 *
 * @Route("enquiry/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"} )
 */
class EnquiryController extends Controller {

    /**
     * Creates a new emission entity.
     *
     * @Route("/new", name="enquiry_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {

        $enquiry = new Enquiry();
        $form = $this->createForm('AppBundle\Form\EnquiryType', $enquiry);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime();
        if ($form->isSubmitted() && $form->isValid()) {
          
            $enquiry->setDateEnvoie($date);

            if ($this->getUser()) {
                $enquiry->setEmetteur($this->getUser());
                $enquiry->setEmailEmetteur($this->getUser()->getEmail());
                $enquiry->setNameEmetteur($this->getUser()->getUsername());
            } else {
                $emetteur = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('email' => $enquiry->getEmailEmetteur()));
                if (!$emetteur) {
                    $emetteur = new User();
                    $emetteur->setEmail($enquiry->getEmailEmetteur());

                    $emetteur->setUsername($enquiry->getNameEmetteur());
                    // Le mot de passe des auditeurs anonymes convergent avec l'email pour un début
                    $emetteur->setPassword($enquiry->getEmailEmetteur());
                    $emetteur->setRegisteredAt($date);
                }
                $enquiry->setEmetteur($emetteur);
            }


        

            if ($enquiry->getSubject() == "temoignage") {
              
                $temoignage = new Temoignage();
                $temoignage->setContenu($enquiry->getBody());
                $temoignage->setAuditeur($enquiry->getEmetteur());
                $temoignage->setVisibilite(false);
                $em->persist($temoignage);
            } else {
                $em->persist($enquiry);
                
                
            }
           
            
            $em->flush();
            
        }
        
    

        return $this->render('default/contact.html.twig', array(
                    'enquiry' => $enquiry,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Lists all enquiry entities.
     *
     * @Route("/new", name="app_contact")
     * @Method("POST")
     */
    public function contactAction(Request $request) {

        $enquiry = new Enquiry();
        $form = $this->createForm('AppBundle\Form\EnquiryType', $enquiry);
        $form->handleRequest($request);


        if ($form->isSubmitted() && ($request->getMethod() == 'POST')) {
            //$form->bind($request);

            if ($form->isValid()) {
                $message = (new \Swift_Message($enquiry->getBody()))
                        ->setFrom($enquiry->getEmail())
                        ->setTo('fopoar@gmail.com')
                        ->setBody(
                        $this->renderView(
                                'default/contact.html.twig', array('name' => $enquiry->getName(), 'form' => $form->createView())
                        ), 'text/html'
                );
                //$enquiry->setEmetteur($this->getUser());
                if ($enquiry->getSubject() == "temoignage") {
                    $em = $this->getDoctrine()->getManager();
                    $temoignage = new Temoignage();
                    // $auditeur = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $_POST['userid']));
                    if ($this->getUser()) {
                        $temoignage->setAuditeur($this->getUser());
                    }

                    $temoignage->setContenu($enquiry->getBody());
                    $temoignage->setVisibilite(false);
                    $em->persist($temoignage);
                    $em->flush();
                }
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('app_contact'));
            }
        }

        return $this->render('default/contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
