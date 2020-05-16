<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Annonce;
use AppBundle\Entity\Emission;
use AppBundle\Entity\Passage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class JsonController extends Controller{

    /**
     * Finds and displays a annonce entity by JSON.
     */
     public function annonceListAction() {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AppBundle:Annonce')->findAll();
		
	  	$response = new Response(json_encode($annonces));
      	$response->headers->set('Content-Type', 'application/json');
   
        return $response;
    }

     /**
     * Finds and displays a annonce entity by JSON.
     */
    public function showAnnonceAction(Annonce $annonce) {

	    $response = new Response(json_encode($annonce));
      	$response->headers->set('Content-Type', 'application/json');
       
	     return $response;
    }

     /**
     * Finds and displays a emission entity by JSON.
     */
    public function emissionListAction() {
        $em = $this->getDoctrine()->getManager();

        $emissions = $em->getRepository('AppBundle:Emission')->findAll();
		
	  	$response = new Response(json_encode($emissions));
      	$response->headers->set('Content-Type', 'application/json');
   
        return $response;
    }


     /**
     * Finds and displays a emission entity by JSON.
     */
    public function showEmissionAction(Emission $emission) {

	    $response = new Response(json_encode($emission));
      	$response->headers->set('Content-Type', 'application/json');
       
	     return $response;
    }

       /**
     * Finds and displays passage entity by JSON.
     */
    public function passageListAction() {
        $em = $this->getDoctrine()->getManager();

        $passages = $em->getRepository('AppBundle:Passage')->findAll();
		
	  	$response = new Response(json_encode($passages));
      	$response->headers->set('Content-Type', 'application/json');
   
        return $response;
    }

        /**
     * Finds and displays passages  entity by JSON.
     */
    public function passageListByEmissionAction(Emission $emission) {
        $em = $this->getDoctrine()->getManager();
        $passages = $em->getRepository('AppBundle:Passage')->findBy(array('emission' => $emission));
	  	$response = new Response(json_encode($passages));
      	$response->headers->set('Content-Type', 'application/json');
   
        return $response;
    }

     /**
     * Finds and displays a emission entity by JSON.
     */
    public function showPassageAction(Passage $passage) {

	    $response = new Response(json_encode($passage));
      	$response->headers->set('Content-Type', 'application/json');
       
	     return $response;
    }

}
