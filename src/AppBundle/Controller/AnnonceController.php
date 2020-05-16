<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Annonce controller.
 *
 * @Route("annonce/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"})
 */
class AnnonceController extends Controller {

   /**
     * Lists all annonce entities.
     *
     * @Route("/",  name="annonce_index")
     * @Method("GET")
     */
     public function indexAction(int $json=0) {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AppBundle:Annonce')->findAll();
		
	  	$response = new Response(json_encode($annonces));
      	$response->headers->set('Content-Type', 'application/json');

   
        return $json ? $this->render('annonce/index.html.twig', array(
                    'annonces' => $response,
		)) : $this->render('annonce/index.html.twig', array(
                    'annonces' => $annonces,
		)) ;
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/{id}", name="annonce_show")
     * @Method("GET")
     */
    public function showAction(Annonce $annonce,int $json=0) {

	    $response = new Response(json_encode($annonce));
      	$response->headers->set('Content-Type', 'application/json');
       
	     return $json ? $this->render('annonce/show.html.twig', array(
                    'annonce' => $response,
		)) : $this->render('annonce/show.html.twig', array(
                   'annonce' => $annonce,
		)) ;
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/like/{id}", name="annonce_like")
     * @Method("POST")
     */
    public function likeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('AppBundle:Annonce');

        if (isset($_POST['vote'])) {
          
            // Récupération de l'annonce en cours de vote
            $announceId = $request->get("id");
            $annonce = $annonceRepository->find($announceId);
            // Récupération de l'auditeur
            $auditeur = $this->get('security.token_storage')->getToken()->getUser();
            if ($auditeur) { // Si l'auditeur votant est connecté
                // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                $voteRepository = $em->getRepository('AppBundle:Vote');
                $votes = $voteRepository->findOneByUserAnnonce($auditeur->getId(), $announceId);
                if ( $votes < 1 ) {
                    // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                        // On instancie un nouveau vote
                    $vote = new Vote();
                    $vote->setAuteur($auditeur);
                    $vote->setAnnonce($annonce);
                    $vote->setDate(new \DateTime());
                    $vote->setValue(1);
                        
                    $likecount = $request->get("vote");
                        // On incrémente leslike de l'annonce
                    $annonce->setLikeCount($likecount + 1);
                    $annonce->addVote($vote);
                        // On persiste le vote
                    $em->persist($vote);
                    
                    $em->flush();
                }
            }
        }

        return $this->render('annonce/show.html.twig', array(
                    'annonce' => $annonce,
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/dislike/{id}", name="annonce_dislike")
     * @Method("POST")
     */
    public function dislikeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('AppBundle:Annonce');
        if (isset($_POST['vote'])) {
            // Récupération de l'annonce en cours de vote
            $announceId = $request->get("id");
            $annonce = $annonceRepository->find($announceId);
            // Récupération de l'auditeur
            $auditeur = $this->get('security.token_storage')->getToken()->getUser();
            if ($auditeur) { // Si l'auditeur votant est connecté
                // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                $voteRepository = $em->getRepository('AppBundle:Vote');
                $votes = $voteRepository->findOneByUserAnnonce($auditeur->getId(), $announceId);
                if ( $votes < 1 ) {
                    // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                        // On instancie un nouveau vote
                    $vote = new Vote();
                    $vote->setAuteur($auditeur);
                    $vote->setAnnonce($annonce);
                    $vote->setDate(new \DateTime());
                    $vote->setValue(-1); 
                    $dislikecount = $request->get("vote");
                        // On incrémente leslike de l'annonce
                    $annonce->setDislikeCount($dislikecount + 1);
                    $annonce->addVote($vote);
                        // On persiste le vote
                    $em->persist($vote);
                    $em->flush();
                }
            }
        }
        return $this->render('annonce/show.html.twig', array(
                    'annonce' => $annonce,
        ));
    }

}
