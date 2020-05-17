<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Emission controller.
 */
class FilmController extends Controller
{

/**
 * @Route("/galleryauthor/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"}, name="films_by_author")
 */
    public function galleryByAuthorAction(Request $request)
    {
        if ($_POST["author"]) {
            $author = $_POST["author"];
            if ($author != null) {
                $em = $this->getDoctrine()->getManager();
                $journalist = $em->getRepository('ApplicationSonataUserBundle:User')->findOneBy(array('username' => $author));
               
                $journalists = $this->getDoctrine()
                    ->getEntityManager()
                    ->createQuery(
                        'SELECT u FROM ApplicationSonataUserBundle:User u, AppBundle:Film  f WHERE f.journalist=u.id  ORDER BY u.username ASC'
                    )->getResult();
                $films  = $this->getDoctrine()
                ->getEntityManager()
                ->createQuery(
                    'SELECT f FROM ApplicationSonataUserBundle:User u, AppBundle:Film  f WHERE u.id=f.journalist  and u.username=:username ORDER BY f.id ASC'
                )->setParameter('username', $author)->getResult();
                return $this->render('film/listfilm.html.twig', array('films' => $films, 'journalists' => $journalists, 'journalist' => $journalist));
            }
        }
        // return new Response("No Students");
    }

    /**
     * @Route("/gallery/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"}, name="gallery")
     */
    public function galleryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $journalists = $this->getDoctrine()
            ->getEntityManager()
            ->createQuery(
                'SELECT u FROM ApplicationSonataUserBundle:User u, AppBundle:Film  f WHERE f.journalist=u.id  ORDER BY f.id ASC'
            )->getResult();
        $gallery = $em->getRepository('AppBundle:Film')->findAll();
        foreach ($gallery as $film) {
            $film->setUrl(str_replace("watch?v=", "embed/", $film->getPath()));
        }

        return $this->render('film/gallery.html.twig', [
            'gallery' => $gallery,
            'journalists' => $journalists,

        ]);
    }
}
