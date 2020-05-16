<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
use AppBundle\Entity\Passage;
use AppBundle\Entity\Emission;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
/**
 * Emission controller.
 *
 * @Route("emission/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"})
 */
class EmissionController extends Controller {

    /**
     * Lists all emission entities.
     *
     * @Route("/", name="emission_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, int $json=0) {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Emission')->createQueryBuilder('bp');
        $query = $queryBuilder->getQuery();
        $paginator = $this->get('knp_paginator');
        
        $emissionsFind = $em->getRepository('AppBundle:Emission')->findAll();
        $emissions = $this->get('knp_paginator')->paginate($emissionsFind,$this->get('request')->query->get('page', 1),4);
       
        $emissions->setCustomParameters([
            'position' => 'centered',
            'size' => 'large',
            'rounded' => true,
        ]);
	  
	    
	  	$response = new Response(json_encode($emissions));
      	$response->headers->set('Content-Type', 'application/json');

   
        return ($json==1) ? $this->render('emission/index.html.twig', array(
                    'emissions' => $response,
		)) : $this->render('emission/index.html.twig', array(
                   'emissions' => $emissions
		)) ;
    }

    /**
     * Creates a new emission entity.
     *
     * @Route("/new", name="emission_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $emission = new Emission();
        $form = $this->createForm('AppBundle\Form\EmissionType', $emission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emission);
            $em->flush();

            return $this->redirectToRoute('emission_show', array('id' => $emission->getId()));
        }

        return $this->render('emission/new.html.twig', array(
                    'emission' => $emission,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a emission entity.
     *
     * @Route("/{id}", name="emission_show")
     * @Method("GET")
     */
    public function showAction(Emission $emission, int $json=0) {
        $deleteForm = $this->createDeleteForm($emission);
		$response = new Response(json_encode($emission));
      	$response->headers->set('Content-Type', 'application/json');
	  
       
	     return ($json==1) ? $this->render('emission/show.html.twig', array(
                    'emission' => $response,
		            'delete_form' => $deleteForm->createView(),
		)) : $this->render('emission/show.html.twig', array(
                    'emission' => $emission,
		            'delete_form' => $deleteForm->createView(),
		)) ;
    }

    /**
     * Displays a form to edit an existing emission entity.
     *
     * @Route("/{id}/edit", name="emission_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Emission $emission) {
        $deleteForm = $this->createDeleteForm($emission);
        $editForm = $this->createForm('AppBundle\Form\EmissionType', $emission);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emission_edit', array('id' => $emission->getId()));
        }

        return $this->render('emission/edit.html.twig', array(
                    'emission' => $emission,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a emission entity.
     *
     * @Route("/{id}", name="emission_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Emission $emission) {
        $form = $this->createDeleteForm($emission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emission);
            $em->flush();
        }

        return $this->redirectToRoute('emission_index');
    }

    /**
     * Creates a form to delete a emission entity.
     *
     * @param Emission $emission The emission entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emission $emission) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('emission_delete', array('id' => $emission->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function contactAction() {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('AppBundle_contact'));
            }
        }

        return $this->render('default/contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/like/{id}", name="passage_like")
     * @Method("POST")
     */
    public function likeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $passageRepository = $em->getRepository('AppBundle:Passage');
        $emissionRepository = $em->getRepository('AppBundle:Emission');
        if (isset($_POST['id']) && isset($_POST['emissionid']) && isset($_POST['vote'])) {
            // Récupération de l'annonce en cours de vote
            $passageId = $_POST['id'];
            $emissionid = $_POST['emissionid'];
            $passage = $passageRepository->find($passageId);
            $emission = $emissionRepository->find($emissionid);
            if ($passage && $emission) {
                if ($this->get('security.context')->isGranted('ROLE_USER')) { // Si l'auditeur votant est connecté
                    // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                    $voteRepository = $em->getRepository('AppBundle:Vote');
                    $auditeur = $this->get('security.context')->getToken()->getUser();
                    $votes = $voteRepository->findOneByUserPassage($auditeur->getId(), $passageId);
                    if ($votes < 1) {
                        // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                        // On instancie un nouveau vote
                        $vote = new Vote();
                        $vote->setAuteur($auditeur);
                        $vote->setPassage($passage);
                        $vote->setDate(new \DateTime());
                        $vote->setValue(1);
                        $likecount = $request->get("vote");
                        // On incrémente leslike de l'annonce
                        $passage->setLikeCount($likecount + 1);
                        $passage->addVote($vote);
                        // On persiste le vote
                        $em->persist($vote);
                        $em->flush();
                    }
                } else {
                    throw new AccessDeniedException('Seuls les auditeurs connectés peuvent votés');
                }
            }
        }
        return $this->render('emission/show.html.twig', array(
                    'emission' => $emission,
        ));
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/dislike/{id}", name="passage_dislike")
     * @Method("POST")
     */
    public function dislikeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $passageRepository = $em->getRepository('AppBundle:Passage');
        $emissionRepository = $em->getRepository('AppBundle:Emission');
        if (isset($_POST['id']) && isset($_POST['emissionid']) && isset($_POST['vote'])) {
            // Récupération de l'annonce en cours de vote
            $passageId = $_POST['id'];
            $emissionid = $_POST['emissionid'];
            $passage = $passageRepository->find($passageId);
            $emission = $emissionRepository->find($emissionid);
            if ($passage && $emission) {
                if ($this->get('security.context')->isGranted('ROLE_USER')) { // Si l'auditeur votant est connecté
                    // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                    $voteRepository = $em->getRepository('AppBundle:Vote');
                    $auditeur = $this->get('security.context')->getToken()->getUser();
                    $votes = $voteRepository->findOneByUserPassage($auditeur->getId(), $passageId);
                    if ($votes < 1) {
                        // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                        // On instancie un nouveau vote
                        $vote = new Vote();
                        $vote->setAuteur($auditeur);
                        $vote->setPassage($passage);
                        $vote->setDate(new \DateTime());
                        $vote->setValue(-1);
                        $dislikecount = $_POST['vote'];
                        // On incrémente leslike de l'annonce
                        $passage->setDislikeCount($dislikecount + 1);
                        $passage->addVote($vote);
                        // On persiste le vote
                        $em->persist($vote);
                        $em->flush();
                    }
                } else {
                    throw new AccessDeniedException('Seuls les auditeurs connectés peuvent votés');
                }
            }
        }
        return $this->render('emission/show.html.twig', array(
                    'emission' => $emission,
        ));
    }

    /**
     * Liste dynamique et asynchrone des produits
     *
     * @Route("/list/reseach", name="autocopletionresearch")
     * @Method({"GET", "POST"})
     */
    function listSearchAction(Request $req) {

        $results = array();
        $critere = trim(strip_tags($req->get('term')));
        $em = $this->getDoctrine()->getManager();
        $resultats = $em->getRepository('AppBundle:Passage')->findAllLike($critere);
        foreach ($resultats as $p) {
            $results[] = $p->getEmission() . " " . $p->getKeywords();
        }

        $response = new JsonResponse();
        $response->setData($results);
        return $response;
    }

    /**
     * Liste dynamique et asynchrone des produits
     *
     * @Route("/find", name="")
     * @Method({"GET"})
     */
    function listFindAction(Request $req) {

        $em = $this->getDoctrine()->getManager();
        $keyword = $req->get("keyword");
        if(!empty($keyword)){
            $tok = strtok($keyword, " ");
            while ($tok !== false) {
               $listpassages[] = $em->getRepository("AppBundle:Passage")->findLikeBy($tok);
                $tok = strtok(" \n\t");
            }

    //        $passages = $this->get('knp_paginator')->paginate(
    //                $listpassages, $req->query->get('page', 2)
    //        );
            return $this->render("emission/research.html.twig", array('listpassages' => $listpassages));
        }
        else
        {
              return $this->redirectToRoute('homepage');
        }
    }

}
