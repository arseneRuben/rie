<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Temoignage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Temoignage controller.
 *
 * @Route("temoignage/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"})
 */
class TemoignageController extends Controller {

    /**
     * Lists all temoignage entities.
     *
     * @Route("/", name="temoignage_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        
        $temoignagesFind = $em->getRepository('AppBundle:Temoignage')->findAll();
        $temoignages = $this->get('knp_paginator')->paginate($temoignagesFind, $this->get('request')->query->get('page', 1),4);

       $temoignages->setCustomParameters([
            'position' => 'centered',
            'size' => 'large',
            'rounded' => true,
        ]);

        

        return $this->render('temoignage/index.html.twig', array(
                    'temoignages' => $temoignages,
        ));
    }
     /**
     * Finds and displays a emission entity.
     *
     * @Route("/{id}", name="temoignage_show")
     * @Method("GET")
     */
    public function showAction(Temoignage $temoignage) {
        $deleteForm = $this->createDeleteForm($temoignage);

        return $this->render('temoignage/show.html.twig', array(
                    'temoignage' => $temoignage,
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/like/{id}", name="temoignage_like")
     * @Method("POST")
     */
    public function likeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $temoignageRepository = $em->getRepository('AppBundle:Temoignage');

        if (isset($_POST['vote'])) {

            // Récupération de l'annonce en cours de vote
            $temoignageId = $request->get("id");
            $temoignage = $temoignageRepository->find($temoignageId);
            // Récupération de l'auditeur
            $auditeur = $this->get('security.token_storage')->getToken()->getUser();
            if ($auditeur) { // Si l'auditeur votant est connecté
                // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                $voteRepository = $em->getRepository('AppBundle:Vote');
                $votes = $voteRepository->findOneByUserTemoignage($auditeur->getId(), $temoignageId);
                if ($votes < 1) {
                    // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                    // On instancie un nouveau vote
                    $vote = new Vote();
                    $vote->setAuteur($auditeur);
                    $vote->setTemoignage($temoignage);
                    $vote->setDate(new \DateTime());
                    $vote->setValue(1);

                    $likecount = $request->get("vote");
                    // On incrémente leslike de l'annonce
                    $temoignage->setLikeCount($likecount + 1);
                    $temoignage->addVote($vote);
                    // On persiste le vote
                    $em->persist($vote);

                    $em->flush();
                }
            }
        }

        return $this->redirectToRoute('temoignage_index');
    }

    /**
     * Finds and displays a annonce entity.
     *
     * @Route("/dislike/{id}", name="temoignage_dislike")
     * @Method("POST")
     */
    public function dislikeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $temoignageRepository = $em->getRepository('AppBundle:Temoignage');
        if (isset($_POST['vote'])) {
            // Récupération de l'annonce en cours de vote
            $temoignageId = $request->get("id");
            $temoignage = $temoignageRepository->find($temoignageId);
            // Récupération de l'auditeur
            $auditeur = $this->get('security.token_storage')->getToken()->getUser();
            if ($auditeur) { // Si l'auditeur votant est connecté
                // Recherche à propos de savoir si cet auditeur a déjà voté sur cet article
                $voteRepository = $em->getRepository('AppBundle:Vote');
                $votes = $voteRepository->findOneByUserTemoignage($auditeur->getId(), $temoignageId);
                if ($votes < 1) {
                    // Au cas où aucun vote n'a déjà été effectué pas cet auditeur
                    // On instancie un nouveau vote
                    $vote = new Vote();
                    $vote->setAuteur($auditeur);
                    $vote->setTemoignage($temoignage);
                    $vote->setDate(new \DateTime());
                    $vote->setValue(-1);
                    $dislikecount = $request->get("vote");
                    // On incrémente leslike de l'annonce
                    $temoignage->setDislikeCount($dislikecount + 1);
                    $temoignage->addVote($vote);
                    // On persiste le vote
                    $em->persist($vote);
                    $em->flush();
                }
            }
        }
        return $this->redirectToRoute('temoignage_index');
    }

    /**
     * Creates a form to delete a emission entity.
     *
     * @param Emission $emission The emission entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Temoignage $temoignage) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('temoignage_delete', array('id' => $temoignage->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
}
